#!/bin/bash

PROJECT_ROOT="/home/mohammed_alajel/laravel-projects/School"
VIEWS_DIR="$PROJECT_ROOT/resources/views/admin"
ASSETS_DIR="$PROJECT_ROOT/public/assets/admin"
OUTPUT_DIR="$PROJECT_ROOT/storage/css-audit"

# Create output directory
mkdir -p "$OUTPUT_DIR"

echo "=== CSS Audit Started at $(date) ===" > "$OUTPUT_DIR/audit.log"

# 1. Find all CSS references in blade files
echo "Scanning blade files for CSS references..."
grep -rh "URL::asset.*\.css" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | \
    sed -n "s/.*URL::asset('\([^']*\)').*/\1/p" | \
    sort | uniq > "$OUTPUT_DIR/css-referenced.txt"

grep -rh "@vite" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null > "$OUTPUT_DIR/vite-referenced.txt"

# 2. List all CSS files in assets
echo "Cataloging all CSS files..."
find "$ASSETS_DIR/css" -name "*.css" -type f 2>/dev/null > "$OUTPUT_DIR/css-files-ltr.txt"
find "$ASSETS_DIR/css-rtl" -name "*.css" -type f 2>/dev/null > "$OUTPUT_DIR/css-files-rtl.txt"
find "$ASSETS_DIR/plugins" -name "*.css" -type f 2>/dev/null > "$OUTPUT_DIR/css-files-plugins.txt"

# 3. Check which files are actually referenced
echo "Cross-referencing..."
> "$OUTPUT_DIR/css-used.txt"
> "$OUTPUT_DIR/css-potentially-unused.txt"

while read -r css_file; do
    basename=$(basename "$css_file")
    if grep -q "$basename" "$OUTPUT_DIR/css-referenced.txt"; then
        echo "$css_file" >> "$OUTPUT_DIR/css-used.txt"
    else
        echo "$css_file" >> "$OUTPUT_DIR/css-potentially-unused.txt"
    fi
done < <(cat "$OUTPUT_DIR/css-files-ltr.txt" "$OUTPUT_DIR/css-files-plugins.txt" 2>/dev/null)

# 4. Icon library usage analysis
echo "Analyzing icon library usage..."
> "$OUTPUT_DIR/icon-usage.txt"
for icon_prefix in "fa-" "las " "la-" "ion-" "ti-" "mdi-" "fe-" "bx-" "typcn-" "sl-" "flag-icon"; do
    count=$(grep -roh "\b${icon_prefix}[a-z0-9-]*" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | wc -l)
    echo "$icon_prefix: $count uses" >> "$OUTPUT_DIR/icon-usage.txt"
done

# 5. Plugin directory analysis
echo "Analyzing plugin usage..."
> "$OUTPUT_DIR/plugin-usage.txt"
for plugin_dir in "$ASSETS_DIR/plugins"/*; do
    if [ -d "$plugin_dir" ]; then
        plugin_name=$(basename "$plugin_dir")
        count=$(grep -r "$plugin_name" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | wc -l)
        size=$(du -sh "$plugin_dir" 2>/dev/null | cut -f1)
        echo "$plugin_name|$count|$size" >> "$OUTPUT_DIR/plugin-usage.txt"
    fi
done

echo "=== Audit Complete at $(date) ===" >> "$OUTPUT_DIR/audit.log"
echo ""
echo "Audit complete! Reports saved to: $OUTPUT_DIR"
echo ""
echo "Summary:"
echo "- Total CSS files found: $(cat "$OUTPUT_DIR/css-files-ltr.txt" "$OUTPUT_DIR/css-files-plugins.txt" 2>/dev/null | wc -l)"
echo "- Unique CSS references: $(wc -l < "$OUTPUT_DIR/css-referenced.txt")"
echo "- Potentially unused CSS files: $(wc -l < "$OUTPUT_DIR/css-potentially-unused.txt")"

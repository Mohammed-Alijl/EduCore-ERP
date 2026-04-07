#!/bin/bash

PROJECT_ROOT="/home/mohammed_alajel/laravel-projects/School"
VIEWS_DIR="$PROJECT_ROOT/resources/views/admin"
ASSETS_DIR="$PROJECT_ROOT/public/assets/admin"
OUTPUT_DIR="$PROJECT_ROOT/storage/js-audit"

# Create output directory
mkdir -p "$OUTPUT_DIR"

echo "=== JavaScript Audit Started at $(date) ===" > "$OUTPUT_DIR/audit.log"
echo "This audit identifies which JS files are actually used in the application."
echo ""

# 1. Find all JS references in blade files
echo "[1/8] Scanning blade files for <script> tags and JS references..."
grep -rh "URL::asset.*\.js" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | \
    sed -n "s/.*URL::asset('\([^']*\)').*/\1/p" | \
    sort | uniq > "$OUTPUT_DIR/js-referenced-blade.txt"

grep -rh "<script.*src=" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | \
    sed -n 's/.*src=["'\'']\([^"'\'']*\.js\)["\'']/\1/p' | \
    sort | uniq > "$OUTPUT_DIR/js-referenced-script-tags.txt"

# 2. Check @vite directives
echo "[2/8] Checking for @vite directives..."
grep -rh "@vite.*\.js" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null > "$OUTPUT_DIR/js-vite-referenced.txt"

# 3. List all JS files in assets
echo "[3/8] Cataloging all JS files in assets directory..."
find "$ASSETS_DIR/js" -name "*.js" -type f 2>/dev/null > "$OUTPUT_DIR/js-files-main.txt"
find "$ASSETS_DIR/plugins" -name "*.js" -type f 2>/dev/null > "$OUTPUT_DIR/js-files-plugins.txt"

# 4. Analyze DataTables specifically (CRITICAL - user mentioned this)
echo "[4/8] Analyzing DataTables usage and language files..."
> "$OUTPUT_DIR/datatable-analysis.txt"
echo "=== DataTables Analysis ===" >> "$OUTPUT_DIR/datatable-analysis.txt"
echo "" >> "$OUTPUT_DIR/datatable-analysis.txt"

# Check DataTables references
dt_count=$(grep -r "datatable\|DataTable" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | wc -l)
echo "DataTable references in blade files: $dt_count" >> "$OUTPUT_DIR/datatable-analysis.txt"

# List DataTables language files
echo "" >> "$OUTPUT_DIR/datatable-analysis.txt"
echo "DataTables Language Files Found:" >> "$OUTPUT_DIR/datatable-analysis.txt"
find "$ASSETS_DIR/plugins/datatable" -name "*.js" -type f 2>/dev/null | grep -i "i18n\|lang\|locale" >> "$OUTPUT_DIR/datatable-analysis.txt"

# 5. Check for JS dependencies (files that import/require other files)
echo "[5/8] Scanning for JS file dependencies..."
> "$OUTPUT_DIR/js-dependencies.txt"
echo "=== JS Files with Dependencies ===" >> "$OUTPUT_DIR/js-dependencies.txt"

# Look for require, import, or script loading in JS files
find "$ASSETS_DIR" -name "*.js" -type f 2>/dev/null | while read -r jsfile; do
    # Check if this JS file loads other JS files
    if grep -qE "require\(|import |\.getScript\(|\.load\(" "$jsfile" 2>/dev/null; then
        basename=$(basename "$jsfile")
        echo "$basename loads other files:" >> "$OUTPUT_DIR/js-dependencies.txt"
        grep -h "require\(|import |\.getScript\(|\.load\(" "$jsfile" 2>/dev/null | head -5 >> "$OUTPUT_DIR/js-dependencies.txt"
        echo "" >> "$OUTPUT_DIR/js-dependencies.txt"
    fi
done

# 6. Plugin directory analysis
echo "[6/8] Analyzing plugin JS usage..."
> "$OUTPUT_DIR/plugin-js-usage.txt"
for plugin_dir in "$ASSETS_DIR/plugins"/*; do
    if [ -d "$plugin_dir" ]; then
        plugin_name=$(basename "$plugin_dir")

        # Count references in blade files
        blade_count=$(grep -r "$plugin_name" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | wc -l)

        # Count JS files in this plugin
        js_count=$(find "$plugin_dir" -name "*.js" -type f 2>/dev/null | wc -l)

        # Get total size
        size=$(du -sh "$plugin_dir" 2>/dev/null | cut -f1)

        echo "$plugin_name|$blade_count refs|$js_count files|$size" >> "$OUTPUT_DIR/plugin-js-usage.txt"
    fi
done

# 7. Check footer-scripts.blade.php specifically (common JS loading location)
echo "[7/8] Analyzing footer-scripts.blade.php..."
if [ -f "$VIEWS_DIR/layouts/footer-scripts.blade.php" ]; then
    grep -h "\.js" "$VIEWS_DIR/layouts/footer-scripts.blade.php" 2>/dev/null | \
        sed -n 's/.*['\''"].*assets\/admin\/\([^'\''"]*.js\)['\''"].*/\1/p' | \
        sort | uniq > "$OUTPUT_DIR/js-footer-scripts.txt"
    echo "Found $(wc -l < "$OUTPUT_DIR/js-footer-scripts.txt") JS files in footer-scripts.blade.php"
else
    echo "footer-scripts.blade.php not found" > "$OUTPUT_DIR/js-footer-scripts.txt"
fi

# 8. Cross-reference to find potentially unused files
echo "[8/8] Cross-referencing to identify unused JS files..."
> "$OUTPUT_DIR/js-used.txt"
> "$OUTPUT_DIR/js-potentially-unused.txt"

# Combine all referenced files
cat "$OUTPUT_DIR/js-referenced-blade.txt" \
    "$OUTPUT_DIR/js-referenced-script-tags.txt" \
    "$OUTPUT_DIR/js-footer-scripts.txt" 2>/dev/null | \
    sort | uniq > "$OUTPUT_DIR/js-all-referenced.txt"

# Check each JS file
while read -r js_file; do
    basename=$(basename "$js_file")
    # Check if this basename appears in any reference
    if grep -q "$basename" "$OUTPUT_DIR/js-all-referenced.txt"; then
        echo "$js_file" >> "$OUTPUT_DIR/js-used.txt"
    else
        # Double-check it's not a dependency
        if ! grep -q "$basename" "$OUTPUT_DIR/js-dependencies.txt"; then
            echo "$js_file" >> "$OUTPUT_DIR/js-potentially-unused.txt"
        fi
    fi
done < <(cat "$OUTPUT_DIR/js-files-main.txt" "$OUTPUT_DIR/js-files-plugins.txt" 2>/dev/null)

# Generate summary
echo "" | tee -a "$OUTPUT_DIR/audit.log"
echo "=== Audit Summary ===" | tee -a "$OUTPUT_DIR/audit.log"
echo "" | tee -a "$OUTPUT_DIR/audit.log"
echo "Total JS files found: $(cat "$OUTPUT_DIR/js-files-main.txt" "$OUTPUT_DIR/js-files-plugins.txt" 2>/dev/null | wc -l)" | tee -a "$OUTPUT_DIR/audit.log"
echo "Unique JS references in blade: $(cat "$OUTPUT_DIR/js-all-referenced.txt" 2>/dev/null | wc -l)" | tee -a "$OUTPUT_DIR/audit.log"
echo "Files explicitly referenced: $(cat "$OUTPUT_DIR/js-used.txt" 2>/dev/null | wc -l)" | tee -a "$OUTPUT_DIR/audit.log"
echo "Potentially unused files: $(cat "$OUTPUT_DIR/js-potentially-unused.txt" 2>/dev/null | wc -l)" | tee -a "$OUTPUT_DIR/audit.log"
echo "DataTables references: $dt_count" | tee -a "$OUTPUT_DIR/audit.log"
echo "" | tee -a "$OUTPUT_DIR/audit.log"

echo "=== Audit Complete at $(date) ===" | tee -a "$OUTPUT_DIR/audit.log"
echo ""
echo "Reports saved to: $OUTPUT_DIR"
echo ""
echo "⚠️  IMPORTANT: Review DataTables analysis before removing any files!"
echo "   See: $OUTPUT_DIR/datatable-analysis.txt"

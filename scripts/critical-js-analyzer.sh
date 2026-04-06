#!/bin/bash

PROJECT_ROOT="/home/mohammed_alajel/laravel-projects/School"
VIEWS_DIR="$PROJECT_ROOT/resources/views/admin"
ASSETS_DIR="$PROJECT_ROOT/public/assets/admin"
OUTPUT_DIR="$PROJECT_ROOT/storage/js-audit"

mkdir -p "$OUTPUT_DIR"

echo "╔══════════════════════════════════════════════════════════╗"
echo "║   Critical JS Libraries Analysis - DO NOT REMOVE THESE   ║"
echo "╚══════════════════════════════════════════════════════════╝"
echo ""

> "$OUTPUT_DIR/critical-libraries.txt"

# Critical libraries mentioned by user or found in analysis
CRITICAL_LIBS=(
    "datatable"
    "select2"
    "sweet-alert"
    "parsleyjs"
    "jquery"
    "bootstrap"
    "moment"
)

echo "=== CRITICAL LIBRARIES ANALYSIS ===" >> "$OUTPUT_DIR/critical-libraries.txt"
echo "These libraries are essential. DO NOT REMOVE." >> "$OUTPUT_DIR/critical-libraries.txt"
echo "" >> "$OUTPUT_DIR/critical-libraries.txt"

for lib in "${CRITICAL_LIBS[@]}"; do
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    echo "Library: $lib" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

    # Count blade references
    blade_refs=$(grep -r "$lib" "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | wc -l)
    echo "  Blade references: $blade_refs" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

    # Find plugin directory
    if [ -d "$ASSETS_DIR/plugins/$lib" ]; then
        dir="$ASSETS_DIR/plugins/$lib"

        # Count JS files
        js_count=$(find "$dir" -name "*.js" -type f 2>/dev/null | wc -l)
        echo "  JS files: $js_count" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

        # Get directory size
        size=$(du -sh "$dir" 2>/dev/null | cut -f1)
        echo "  Size: $size" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

        # List specific files
        echo "  Files:" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
        find "$dir" -name "*.js" -type f 2>/dev/null | sed 's|.*/||' | sort | head -10 | sed 's/^/    - /' | tee -a "$OUTPUT_DIR/critical-libraries.txt"

        # Check for language/i18n files
        lang_files=$(find "$dir" -name "*.js" -type f 2>/dev/null | grep -iE "i18n|lang|locale|dictionary|translation" | wc -l)
        if [ "$lang_files" -gt 0 ]; then
            echo "  ⚠️  Language files: $lang_files (REQUIRED - DO NOT DELETE)" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
            find "$dir" -name "*.js" -type f 2>/dev/null | grep -iE "i18n|lang|locale" | sed 's|.*/||' | sed 's/^/    🌍 /' | tee -a "$OUTPUT_DIR/critical-libraries.txt"
        fi
    else
        echo "  ⚠️  Directory not found: plugins/$lib" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    fi

    echo "" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
done

# Special DataTables deep analysis
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
echo "DATATABLES - DEEP ANALYSIS (USER PRIORITY)" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

if [ -d "$ASSETS_DIR/plugins/datatable" ]; then
    DT_DIR="$ASSETS_DIR/plugins/datatable"

    # Core files
    echo "" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    echo "📦 Core DataTables Files:" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    find "$DT_DIR" -maxdepth 2 -name "*.js" -type f 2>/dev/null | \
        grep -v "i18n\|lang\|locale" | \
        sed 's|.*/||' | sort | sed 's/^/  ✓ /' | tee -a "$OUTPUT_DIR/critical-libraries.txt"

    # Language files
    echo "" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    echo "🌍 Language/i18n Files (CRITICAL - User Scripts Depend On These):" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    find "$DT_DIR" -name "*.js" -type f 2>/dev/null | \
        grep -iE "i18n|lang|locale|Arabic|English" | \
        sed 's|.*/||' | sort | sed 's/^/  🔒 /' | tee -a "$OUTPUT_DIR/critical-libraries.txt"

    # Extensions (Buttons, etc.)
    echo "" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    echo "🔌 Extensions:" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
    find "$DT_DIR" -name "*.js" -type f 2>/dev/null | \
        grep -iE "button|select|responsive|fixed|autofill|colreorder|keytable|rowgroup|scroller" | \
        sed 's|.*/||' | sort | sed 's/^/  ⚙️  /' | tee -a "$OUTPUT_DIR/critical-libraries.txt"
fi

echo "" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
echo "╔══════════════════════════════════════════════════════════╗" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
echo "║  ⚠️  PRESERVATION RULE: KEEP ALL CRITICAL LIBRARY FILES  ║" | tee -a "$OUTPUT_DIR/critical-libraries.txt"
echo "╚══════════════════════════════════════════════════════════╝" | tee -a "$OUTPUT_DIR/critical-libraries.txt"

echo ""
echo "Critical libraries analysis complete!"
echo "Report saved to: $OUTPUT_DIR/critical-libraries.txt"

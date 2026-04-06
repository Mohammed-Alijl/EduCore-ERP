#!/bin/bash
echo "=== PHASE 2: Medium Impact Deletions ==="
echo ""

PLUGINS_DIR="public/assets/admin/plugins"

# Charts & Visualization
declare -a CHARTS=(
    "chart.js:600KB:Charts library"
    "jquery.flot:584KB:Flot charts"
    "flot.curvedlines:456KB:Flot extension"
    "morris.js:48KB:Morris charts"
    "peity:12KB:Mini charts"
    "raphael:496KB:Graphics library"
)

# Maps
declare -a MAPS=(
    "leaflet:968KB:Map library"
    "gmaps:148KB:Google Maps wrapper"
)

# Others
declare -a OTHERS=(
    "fullcalendar:776KB:Calendar library"
    "prismjs:1MB:Syntax highlighting"
    "prism:24KB:Syntax highlighting"
)

ALL=("${CHARTS[@]}" "${MAPS[@]}" "${OTHERS[@]}")

for item in "${ALL[@]}"; do
    IFS=':' read -r plugin size desc <<< "$item"
    if [ -d "$PLUGINS_DIR/$plugin" ]; then
        actual_size=$(du -sh "$PLUGINS_DIR/$plugin" 2>/dev/null | cut -f1)
        echo "🗑️  Deleting: $plugin"
        echo "   Description: $desc"
        echo "   Size: $actual_size"
        rm -rf "$PLUGINS_DIR/$plugin"
        echo "   ✅ Deleted"
        echo ""
    fi
done

echo "=== PHASE 2 COMPLETE ==="

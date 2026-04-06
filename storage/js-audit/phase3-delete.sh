#!/bin/bash
echo "=== PHASE 3: Small Impact Deletions ==="
echo ""

PLUGINS_DIR="public/assets/admin/plugins"

declare -a PLUGINS=(
    "amazeui-datetimepicker"
    "fancyuploder"
    "jquery-ui-slider"
    "ion-rangeslider"
    "spectrum-colorpicker"
    "pickerjs"
    "jquery-simple-datetimepicker"
    "sumoselect"
    "inputtags"
    "owl-carousel"
    "lightslider"
    "multislider"
    "darggable"
    "custom-scroll"
    "popper.js"
    "gallery"
    "images-comparsion"
    "jQuerytransfer"
    "jquery-countdown"
    "jquery-nice-select"
    "particles.js-master"
    "notify"
    "newsticker"
    "counters"
    "accordion"
    "treeview"
    "horizontal-menu"
)

for plugin in "${PLUGINS[@]}"; do
    if [ -d "$PLUGINS_DIR/$plugin" ]; then
        size=$(du -sh "$PLUGINS_DIR/$plugin" 2>/dev/null | cut -f1)
        echo "🗑️  $plugin ($size)"
        rm -rf "$PLUGINS_DIR/$plugin"
    fi
done

echo ""
echo "=== PHASE 3 COMPLETE ==="

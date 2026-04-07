#!/bin/bash
echo "=== PHASE 4: Deleting Unused Custom JS Files ==="
echo ""

JS_DIR="public/assets/admin/js"

# Chart files
declare -a CHARTS=(
    "chart.chartjs.js"
    "chart.flot.js"
    "chart.flot.sampledata.js"
    "chart.morris.js"
    "chart.peity.js"
    "chart.sparkline.js"
    "echarts.js"
)

# Map files
declare -a MAPS=(
    "map.apple.js"
    "map.bluewater.js"
    "map-leafleft.js"
    "map.mapbox.js"
    "map.shiftworker.js"
    "vector-map.js"
    "jquery.vmap.sampledata.js"
)

# Application features
declare -a APPS=(
    "app-calendar.js"
    "app-calendar-events.js"
    "chat.js"
    "contact.js"
    "check-all-mail.js"
    "mail-two.js"
    "profile.js"
    "invoice.js"
)

# Forms
declare -a FORMS=(
    "advanced-form-elements.js"
    "formelementadvnced.js"
    "form-editor.js"
    "form-layouts.js"
    "form-wizard.js"
    "rangeslider.js"
)

# UI Components
declare -a UI=(
    "modal.js"
    "modal-popup.js"
    "popover.js"
    "tooltip.js"
    "accordion.js"
)

# Dashboard
declare -a DASH=(
    "index-dark.js"
    "index-map.js"
    "dashboard.sampledata.js"
)

# Others
declare -a OTHERS=(
    "image-comparision.js"
    "createWaterBall-jquery.js"
    "newsticker.js"
    "cookie.js"
    "timline.js"
    "left-menu.js"
    "navigation.js"
    "table-data.js"
)

ALL=("${CHARTS[@]}" "${MAPS[@]}" "${APPS[@]}" "${FORMS[@]}" "${UI[@]}" "${DASH[@]}" "${OTHERS[@]}")

count=0
for file in "${ALL[@]}"; do
    if [ -f "$JS_DIR/$file" ]; then
        size=$(du -h "$JS_DIR/$file" 2>/dev/null | cut -f1)
        echo "🗑️  $file ($size)"
        rm -f "$JS_DIR/$file"
        ((count++))
    fi
done

echo ""
echo "Deleted $count custom JS files"
echo "=== PHASE 4 COMPLETE ==="

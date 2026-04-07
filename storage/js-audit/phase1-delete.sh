#!/bin/bash
echo "=== PHASE 1: Deleting Large Unused Plugins ==="
echo ""

PLUGINS_DIR="public/assets/admin/plugins"

# Track total size before deletion
TOTAL_BEFORE=0
TOTAL_AFTER=0

declare -A PLUGINS=(
    ["@fortawesome"]="11MB - Duplicate of fontawesome-free"
    ["jqvmap"]="4MB - Vector maps (0 refs)"
    ["line-awesome"]="3.8MB - Icon library (0 refs)"
    ["echart"]="2.2MB - Charts library (0 refs)"
)

for plugin in "${!PLUGINS[@]}"; do
    if [ -d "$PLUGINS_DIR/$plugin" ]; then
        size=$(du -sh "$PLUGINS_DIR/$plugin" 2>/dev/null | cut -f1)
        echo "🗑️  Deleting: $plugin - ${PLUGINS[$plugin]}"
        echo "   Size: $size"
        rm -rf "$PLUGINS_DIR/$plugin"
        echo "   ✅ Deleted"
        echo ""
    else
        echo "⚠️  Not found: $plugin"
        echo ""
    fi
done

echo "=== PHASE 1 COMPLETE ==="

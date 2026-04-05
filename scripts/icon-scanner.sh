#!/bin/bash

PROJECT_ROOT="/home/mohammed_alajel/laravel-projects/School"
VIEWS_DIR="$PROJECT_ROOT/resources/views/admin"
OUTPUT_DIR="$PROJECT_ROOT/storage/css-audit"

mkdir -p "$OUTPUT_DIR"

echo "Scanning for icon classes in admin blade files..."

# Extract all icon classes
grep -roh 'class="[^"]*"' "$VIEWS_DIR" --include="*.blade.php" 2>/dev/null | \
    grep -oE "(fa-|fas |far |fab |la-|las |lar |ion-|ti-|mdi-|fe-|bx-|typcn-|sl-|flag-icon-)[a-z0-9-]+" | \
    sort | uniq -c | sort -rn > "$OUTPUT_DIR/icon-classes-detailed.txt"

# Categorize by library
echo "=== Font Awesome ===" > "$OUTPUT_DIR/icon-breakdown.txt"
grep -E "(fa-|fas |far |fab )" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Line Awesome ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep -E "(la-|las |lar )" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Ionicons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "ion-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Typicons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "typcn-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Material Design Icons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "mdi-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Feather ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "fe-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Boxicons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "bx-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Themify Icons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "ti-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Simple Line Icons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "sl-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

echo -e "\n=== Flag Icons ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
grep "flag-icon-" "$OUTPUT_DIR/icon-classes-detailed.txt" >> "$OUTPUT_DIR/icon-breakdown.txt" 2>/dev/null || echo "None found" >> "$OUTPUT_DIR/icon-breakdown.txt"

# Summary counts per library
echo -e "\n\n=== SUMMARY ===" >> "$OUTPUT_DIR/icon-breakdown.txt"
for lib in "fa-|fas |far |fab " "la-|las |lar " "ion-" "ti-" "mdi-" "fe-" "bx-" "typcn-" "sl-" "flag-icon-"; do
    total=$(grep -cE "$lib" "$OUTPUT_DIR/icon-classes-detailed.txt" 2>/dev/null || echo "0")
    lib_name=$(echo "$lib" | sed 's/|.*//')
    echo "$lib_name: $total unique classes" >> "$OUTPUT_DIR/icon-breakdown.txt"
done

echo ""
echo "Icon analysis complete! Results saved to:"
echo "- $OUTPUT_DIR/icon-classes-detailed.txt (all icons with usage counts)"
echo "- $OUTPUT_DIR/icon-breakdown.txt (categorized by library)"
echo ""
echo "Quick Summary:"
grep "SUMMARY" -A 12 "$OUTPUT_DIR/icon-breakdown.txt"

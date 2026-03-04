import re

# Update English
with open('lang/en/admin.php', 'r') as f:
    en_content = f.read()

en_addition = """
        'warning_title' => 'Warning: Destructive Zone',
        'warning_body' => 'Are you sure you want to archive this teacher? They will be removed from the active list but can be restored later.',
"""

if "'warning_title'" not in en_content.split("'teachers' => [")[1].split("],")[0]:
    en_content = en_content.replace("'teachers' => [", "'teachers' => [" + en_addition, 1)
    with open('lang/en/admin.php', 'w') as f:
        f.write(en_content)

# Update Arabic
with open('lang/ar/admin.php', 'r') as f:
    ar_content = f.read()

ar_addition = """
        'warning_title' => 'تحذير: منطقة الحذف المؤقت',
        'warning_body' => 'هل أنت متأكد من أرشفة هذا المعلم؟ سيتم إزالته من القائمة النشطة ولكن يمكن استعادته لاحقاً.',
"""

if "'warning_title'" not in ar_content.split("'teachers' => [")[1].split("],")[0]:
    ar_content = ar_content.replace("'teachers' => [", "'teachers' => [" + ar_addition, 1)
    with open('lang/ar/admin.php', 'w') as f:
        f.write(ar_content)

print("Translations added successfully.")

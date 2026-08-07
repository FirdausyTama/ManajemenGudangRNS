const fs = require('fs');

const files = [
    'resources/views/admin/rekanan/create.blade.php',
    'resources/views/admin/rekanan/edit.blade.php',
    'resources/views/admin/rekanan/show.blade.php'
];

const basePath = 'c:\\Users\\LEGION\\Documents\\#SKRIPSI\\ManagementGudangRNS\\';

for (let file of files) {
    let fullPath = basePath + file;
    if (fs.existsSync(fullPath)) {
        let content = fs.readFileSync(fullPath, 'utf8');
        
        // Use a more relaxed regex to find the script tag containing toggleSidebar
        let newContent = content.replace(/<script>[\s\S]*?toggleSidebar[\s\S]*?<\/script>/, '');

        if (content !== newContent) {
            fs.writeFileSync(fullPath, newContent);
            console.log('Removed duplicate script from ' + file);
        } else {
            console.log('Script block not found in ' + file + ' (or already removed).');
        }
    }
}

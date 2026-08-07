const fs = require('fs');

const files = [
    'resources/views/admin/rekanan/create.blade.php',
    'resources/views/admin/rekanan/edit.blade.php',
    'resources/views/admin/rekanan/index.blade.php',
    'resources/views/admin/rekanan/show.blade.php'
];

const basePath = 'c:\\Users\\LEGION\\Documents\\#SKRIPSI\\ManagementGudangRNS\\';

for (let file of files) {
    let fullPath = basePath + file;
    if (fs.existsSync(fullPath)) {
        let content = fs.readFileSync(fullPath, 'utf8');
        
        // Remove the script block
        let newContent = content.replace(/<script>\s*document\.addEventListener\('DOMContentLoaded', function\(\) \{\s*const sidebar = document\.getElementById\('sidebar'\);\s*const overlay = document\.getElementById\('sidebar-overlay'\);\s*const toggleBtn = document\.getElementById\('sidebar-toggle-btn'\);\s*const mainContent = document\.getElementById\('main-content'\);\s*function toggleSidebar\(\) \{\s*sidebar\.classList\.toggle\('-translate-x-full'\);\s*overlay\.classList\.toggle\('hidden'\);\s*\}\s*if\(toggleBtn\) toggleBtn\.addEventListener\('click', toggleSidebar\);\s*if\(overlay\) overlay\.addEventListener\('click', toggleSidebar\);\s*\}\);\s*<\/script>/gs, '');

        if (content !== newContent) {
            fs.writeFileSync(fullPath, newContent);
            console.log('Removed duplicate script from ' + file);
        } else {
            console.log('Script block not found in ' + file + ' (or already removed).');
        }
    }
}

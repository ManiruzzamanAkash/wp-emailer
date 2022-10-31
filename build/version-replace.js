const fs = require('fs-extra');
const replace = require('replace-in-file');

const pluginFiles = ['includes/**/*', 'templates/*', 'src/*', 'wpemailer.php'];

const { version } = JSON.parse(fs.readFileSync('package.json'));

replace({
    files: pluginFiles,
    from: /WP_EMAILER_SINCE/g,
    to: version,
});

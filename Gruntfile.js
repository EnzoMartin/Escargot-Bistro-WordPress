const path = require('path');
const libPath = path.join(__dirname, './wp-content/themes/escargot-bistro/library');
const cssPath = path.join(libPath,'css');
const scssPath = path.join(libPath,'scss');

module.exports = function(grunt){
    grunt.initConfig({
        pkg:grunt.file.readJSON('package.json'),
        sass:{
            dev:{
                options:{
                    style:'expanded',
                    sourcemap:'none',
                    compass:true,
                    update:true
                },
                files:{
                    [path.join(cssPath,'admin.css')]:path.join(scssPath,'admin.scss'),
                    [path.join(cssPath,'editor-style.css')]:path.join(scssPath,'editor-style.scss'),
                    [path.join(cssPath,'ie.css')]:path.join(scssPath,'ie.scss'),
                    [path.join(cssPath,'login.css')]:path.join(scssPath,'login.scss'),
                    [path.join(cssPath,'style.css')]:path.join(scssPath,'style.scss')
                }
            },
            prod:{
                options:{
                    style:'compressed',
                    sourcemap:'none',
                    compass:true
                },
                files:{
                    [path.join(cssPath,'admin.css')]:path.join(scssPath,'admin.scss'),
                    [path.join(cssPath,'editor-style.css')]:path.join(scssPath,'editor-style.scss'),
                    [path.join(cssPath,'ie.css')]:path.join(scssPath,'ie.scss'),
                    [path.join(cssPath,'login.css')]:path.join(scssPath,'login.scss'),
                    [path.join(cssPath,'style.css')]:path.join(scssPath,'style.scss')
                }
            }
        },
        watch: {
            scss: {
                files: [libPath + '/**/*.scss'],
                tasks: ['sass:dev'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default',['sass:dev','watch:scss']);
};
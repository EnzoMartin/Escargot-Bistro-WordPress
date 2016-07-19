const path = require('path');
const libPath = path.join(__dirname, './wp-content/themes/escargot-bistro/library');

const cssPath = path.join(libPath,'css');
const jsPath = path.join(libPath,'js');

const scssPath = path.join(libPath,'scss');
const scriptsPath = path.join(jsPath,'scripts.js');
const adminPath = path.join(jsPath,'admin.js');
const jqueryPath = path.join(jsPath,'jquery-light.min.js');

module.exports = function(grunt){
    grunt.initConfig({
        pkg:grunt.file.readJSON('package.json'),
        sass:{
            dev:{
                options:{
                    style:'compressed',
                    sourcemap:'auto',
                    compass:true,
                    update:true
                },
                files:{
                    [path.join(cssPath,'admin.css')]:path.join(scssPath,'admin.scss'),
                    [path.join(cssPath,'editor-style.css')]:path.join(scssPath,'editor-style.scss'),
                    [path.join(cssPath,'ie.css')]:path.join(scssPath,'ie.scss'),
                    [path.join(cssPath,'login.css')]:path.join(scssPath,'login.scss'),
                    [path.join(cssPath,'style.css')]:path.join(scssPath,'style.scss'),
                    [path.join(cssPath,'print.css')]:path.join(scssPath,'print.scss')
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
                    [path.join(cssPath,'style.css')]:path.join(scssPath,'style.scss'),
                    [path.join(cssPath,'print.css')]:path.join(scssPath,'print.scss')
                }
            }
        },
        uglify: {
            dist: {
                options:{
                    compress:true,
                    sourceMap:false,
                    mangle:true,
                    preserveComments: false,
                    screwIE8: true
                },
                files:{
                    [scriptsPath]:[scriptsPath],
                    [jqueryPath]:[jqueryPath],
                    [adminPath]:[adminPath]
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
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default',['sass:dev','watch:scss']);
    grunt.registerTask('prod',['sass:prod','uglify']);
};

module.exports = function(grunt){
  require('time-grunt')(grunt);

  //timer.init(grunt);
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

  grunt.initConfig({

    jade: {
      
      // Пересобираем все шаблоны
      all: {
        files: [{
          expand: true,
          cwd: 'new/jade',
          src: ['page/**/*.jade', '!block/**/*.jade', '!extend/**/*.jade'],
          dest: 'new/html',
          ext: ".html"
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
        }
      },
      // пересобираем документацию
      docs: {
        files: [{
          expand: true,
          cwd: 'new/jade',
          src: ['docs/**/*.jade', ],
          dest: 'new/html',
          ext: ".html"
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
          // data: grunt.file.readJSON(pathJade)
        }
      },
      // lite версии страниц
      // lite: {
      //   files: [{
      //     expand: true,
      //     cwd: 'new/jade',
      //     src: ['page/**/*-lite.jade', ],
      //     dest: 'new/html',
      //     ext: ".html"
      //   }],
      //   options: {
      //     pretty: true,
      //     client: false,
      //     cache: true,
      //     nospawn : true,
      //     // data: grunt.file.readJSON(pathJade)
      //   }
      // }
    },

    // Удаляем файлы
    // clean: {
    //   new: ['new/css/tidy.css']
    // },

    ///////////////////////////////////////////////////
    // css
    //чистим css от не используемых стилей
    less: {
      old: {
        files: {
          'stylesheets/common.css': ['less/all1.less'],
          'stylesheets/global.css': ['less/all2.less'],
          // стили страницы вакансий
          'stylesheets/vacancy.css': ['less/vacancy.less'],
          // стили html баннеров, независимы от всего 
          'stylesheets/banner.css': ['less/banner.less']
        },
        options: {
          compress: true,
          cleancss: true,
        }
      },
      old_dev: {
        files: {
          'stylesheets/common.dev.css': ['less/all1.less'],
          'stylesheets/global.dev.css': ['less/all2.less'],
        },
        options: {
          sourceMap: true,
        }
      },
      newestdev: {
        files: {
          'new/css/all1.dev.css': ['new/less/all1.less'] 
        },
        options: {
          sourceMap: true,
          /*sourceMapFilename: 'new/css/all1.css.map',*/
          /*sourceMapRootpath: 'new/css',
          sourceMapURL: 'new/css/all1.css.map',*/
        },
      },
      litedev: {
        files: {
          'new/css/lite.dev.css': ['new/less/lite.less'] 
        },
        options: {
          sourceMap: true,
          /*sourceMapFilename: 'new/css/all1.css.map',*/
          /*sourceMapRootpath: 'new/css',
          sourceMapURL: 'new/css/all1.css.map',*/
        }
      },
      // newest: {
      //   files: {
      //     'new/css/all1.css': ['new/less/all1.less'] 
      //   },
      //   options: {
      //     compress: true,
      //     cleancss: true,
      //   }
      // }
    },

    uncss: {
      new: {
        options: {
          stylesheets  : ['/css/all1.dev.css'],
          timeout      : 1000,

          htmlroot     : 'new',
          ignore       : [
            // Выбираем все стили где в начале .clsss
            /.dropdown+/,
            /.flag+/,
            /.jcrop+/,
            /.mfp+/,
            /.redactor+/,
            /.select2+/,
            /.tooltip+/,
          ],
        },
        src: ['new/html/docs/*.html', 'new/html/page/**/*.html'],
        dest: 'new/css/all1.css'
      },
      lite: {
        options: {
          stylesheets  : ['/css/all1.dev.css'],
          timeout      : 1000,

          htmlroot     : 'new',
          ignore       : [
            // Выбираем все стили где в начале .clsss
            /.dropdown+/,
            /.mfp+/,
            /.tooltip+/,
          ],
        },
        src: ['new/html/page/**/*-lite.html'],
        dest: 'new/css/lite.css'
      },
    },
    // Объеденяем медиа запросы в css
    cmq: {
      options: {
        log: true
      },
      new: {
        files: {
          'new/css/all1.css': ['new/css/all1.dev.css']
        }
      },
      lite: {
        files: {
          'new/css/lite.css': ['new/css/lite.css']
        }
      }
    },
    // Сжимаем css
    cssmin: {
      new: {
        options: {
          compatibility: 'ie8',
          keepSpecialComments: 0,
          report: 'max'
        },
        files: {
          'new/css/all1.css': 'new/css/all1.css'
        }
      },
      lite: {
        options: {
          compatibility: 'ie8',
          keepSpecialComments: 0,
          report: 'max'
        },
        files: {
          'new/css/lite.css': 'new/css/lite.css'
        }
      }
    },
    // Умное сжате css
    csso: {
      compress: {
        options: {
          report: 'gzip'
        },
        files: {
          'new/css/all1.css': ['new/css/all1.css']
        }
      },
      lite: {
        options: {
          report: 'gzip'
        },
        files: {
          'new/css/lite.css': ['new/css/lite.css']
        }
      }
    },
    // /css
    ////////////////////////////// 

    svgmin: {                       // Task
      options: {                  // Configuration that will be passed directly to SVGO
          plugins: [{
              removeViewBox: false
          }, {
              removeUselessStrokeAndFill: false
          }, {
              convertPathData: { 
                  straightCurves: false // advanced SVGO plugin option
              }
          }]
      },
      dist: {                     // Target
          files: [{               // Dictionary of files
              expand: true,       // Enable dynamic expansion.
              cwd: 'new/images/svg',     // Src matches are relative to this path.
              src: ['**/*.svg'],  // Actual pattern(s) to match.
              dest: 'new/images/svg/min',       // Destination path prefix.
              ext: '.min.svg'     // Dest filepaths will have this extension.
              // ie: optimise img/src/branding/logo.svg and store it in img/branding/logo.min.svg
          }]
      },
    },

    watch: {

      // Следим за статическими страницами
      jadepage: {
        files: ['new/jade/page/**/*.jade'],
        tasks: ['newer:jade:all'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      // Пересобираем документацию
      jadedocs: {
        files: ['new/jade/docs/**/*.jade'],
        tasks: ['jade:docs'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      // Следим за старым less 
      lessold: {
        files: ['less/**/*.less'],
        tasks: ['less:old', 'less:old_dev'],
        options: {
          livereload: true,
        },
      },
      // следим за новым less
      newless: {
        files: ['new/less/**/*.less'],
        tasks: ['less:newestdev'/*, 'cmq', 'cssmin', 'csso'*/],
        options: {
          livereload: true,
        },
      },
      // следим за новым less
      liteless: {
        files: ['new/less/**/*.less'],
        tasks: ['less:litedev'/*, 'cmq', 'cssmin', 'csso'*/],
        options: {
          livereload: true,
        },
      },
      // Следим за изменениями в рассылках
      email: {
        files: ['new/html/email/**/*'],
        // tasks:['less:newest'],
        options: {
          livereload: true,
        },
      },
    },

    // Поднимаем сервер
    connect: {
      server: {
        options: {
          port: 4000,
          base: '.',
        }
      }
    },
  });

  // grunt.loadNpmTasks('grunt-merge-json');
  // grunt.loadNpmTasks('grunt-contrib-jade');
  // grunt.loadNpmTasks('grunt-newer');
  // grunt.loadNpmTasks('grunt-contrib-less');
  // grunt.loadNpmTasks('grunt-contrib-watch');
  // grunt.loadNpmTasks('grunt-contrib-connect');
  // grunt.loadNpmTasks('grunt-contrib-imagemin');
  // grunt.loadNpmTasks('grunt-newer');
  // grunt.loadNpmTasks('grunt-uncss');

  grunt.registerTask('bild', ['css:new', 'css:lite'/*, 'jade'*/]);
  grunt.registerTask('css-new', ['less:newestdev','uncss:new', 'cmq:new', 'cssmin:new', 'csso:new']);
  grunt.registerTask('css-lite', ['less:litedev','uncss:lite', 'cmq:lite', 'cssmin:lite', 'csso:lite']);
  grunt.registerTask('default', [
    'connect',
    // 'uncss',
    // 'merge-json',
    'watch', 
  ]);

  // grunt.event.on('watch', function(action, filepath, target) {

  // });



};

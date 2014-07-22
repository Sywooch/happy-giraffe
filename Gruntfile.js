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
          src: ['new/jade/docs/**/*.jade', ], // 'lite/jade/docs/**/*.jade', 
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

      // Пересобираем все шаблоны
      lite_all: {
        files: [{
          expand: true,
          cwd: 'lite/jade',
          src: ['page/**/*.jade', '!block/**/*.jade', '!extend/**/*.jade'],
          dest: 'lite/html',
          ext: ".html"
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
        }
      },
    },

    // Удаляем файлы
    // clean: {
    //   new: ['new/css/tidy.css']
    // },

    ///////////////////////////////////////////////////
    // css
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
        },
      },


      litedev: {
        
        files: [{
          expand: true,
          cwd: 'lite/less/',
          src: ['*.less',],
          dest: 'lite/css/dev/',
          ext: '.css'
        }],
        options: {
          sourceMap: true,
        }
      },
    },

    // неиспользуемые стили
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
      lite_blog: {
        options: {
          stylesheets  : ['/css/dev/all.css'],
          timeout      : 1000,

          htmlroot     : 'lite',
          ignore       : [
            // Выбираем все стили где в начале .clsss
            // /.dropdown+/,
            /.mfp+/,
            /.tooltip+/,
          ],
        },
        src: ['lite/html/page/blog/**/*.html'],
        dest: 'lite/css/min/blog.css'
      },
    },
    // Объеденяем медиа запросы в css
    cmq: {
      options: {
        log: true
      },
      new: {
        files: {
          'new/css/all1.css': ['new/css/all1.css']
        }
      },
      // lite: {
      //   files: {
      //     'lite/css/min/*.css': ['lite/css/min/*.css']
      //   }
      // },
      lite: {
        expand: true,
        cwd: 'lite/css/min/',
        src: ['*.css',],
        dest: 'lite/css/min/',
        ext: '.css'
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
        files: [{
          expand: true,
          cwd: 'lite/css/min/',
          src: ['*.css',],
          dest: 'lite/css/min/',
          ext: '.css'
        }]
      }
    },
    // Умное сжате css
    csso: {
      new: {
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
        files: [{
          expand: true,
          cwd: 'lite/css/min/',
          src: ['*.css',],
          dest: 'lite/css/min/',
          ext: '.css'
        }]
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
        files: ['new/jade/page/**/*.jade', 'lite/jade/page/**/*.jade'],
        tasks: ['newer:jade'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      // Пересобираем документацию
      jadedocs: {
        files: ['new/jade/docs/**/*.jade', ], // 'lite/jade/docs/**/*.jade'
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
        files: ['lite/less/**/*.less'],
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

  //grunt.registerTask('bild', ['css:new', 'css:lite'/*, 'jade'*/]);
  grunt.registerTask('css-new', ['less:newestdev','uncss:new', 'cmq:new', 'cssmin:new', 'csso:new']);

  // lite tasks
  grunt.registerTask('blog', ['jade:lite_all', 'less:litedev','uncss:lite_blog', 'cmq:lite', 'cssmin:lite', 'csso:lite']);

  // Базовый для разработки верстки
  grunt.registerTask('default', [
    'connect',
    'watch', 
  ]);
};

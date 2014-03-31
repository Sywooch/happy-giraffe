module.exports = function(grunt){
  var timer = require("grunt-timer");
  timer.init(grunt);

  // json for jade 
  // var pathJade = "new/jade/mass/data.json";
  
  grunt.initConfig({
    jade: {
      page: {
        files: [{
          "new/html/page/wysiwyg/wysiwyg.html": "new/jade/page/wysiwyg/wysiwyg.jade",
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
          ext: ".html",
          expand: true,
          //data: grunt.file.readJSON(pathJade)
        }
      },
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
          // data: grunt.file.readJSON(pathJade)
        }
      }
    },

    
    less: {
      old: {
        files: {
          'stylesheets/common.css': ['less/all1.less'],
          'stylesheets/global.css': ['less/all2.less'],
        },
        options: {
          compress: true,
          cleancss: true,
          // sourceMap: true,
          // sourceMapFilename: 'css/all.css.map',
          // sourceMapRootpath: '',
          // sourceMapBasepath: ''
        }
      },
      old_dev: {
        files: {
          'stylesheets/common.dev.css': ['less/all1.less'],
          'stylesheets/global.dev.css': ['less/all2.less'],
          'stylesheets/vacancy.css': ['less/vacancy.less']
        },
        options: {
          sourceMap: true,
          // sourceMapFilename: 'css/all.css.map',
          // sourceMapRootpath: '',
          // sourceMapBasepath: ''
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
        }
      },
      newest: {
        files: {
          'new/css/all1.css': ['new/less/all1.less'] 
        },
        options: {
          compress: true,
          cleancss: true,
        }
      }
    },

    // imagemin: {
    //   dynamic: {
    //     files: [{
    //       expand: true,
    //       cwd: 'new/images',
    //       src: ['**/*.{png,jpg,gif}'],
    //       dest: 'new/images1',
    //     }],
    //     options: {
    //         cache: false
    //     }
    //   }
    // },

    watch: {
      reload: {
        files: ['new/jade/block/**/*.jade', 'new/jade/extend/**/*.jade'],
        tasks: ['jade:all'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      jade: {
        files: ['new/jade/page/**/*.jade'],
        tasks: ['jade:page'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      lessold: {
        files: ['less/**/*.less'],
        tasks: ['less:old', 'less:old_dev'],
        options: {
          livereload: true,
        },
      },
      less: {
        files: ['new/less/**/*.less'],
        tasks: ['less:newest', 'less:newestdev'],
        options: {
          livereload: true,
        },
      },
      // imagemin: {
      //   files: ['new/images/**/*.{png,jpg,gif}'],
      //   tasks: ['newer:imagemin'],
      // }
    },
    connect: {
      server: {
        options: {
          port: 4000,
          base: '.',
        }
      }
    },
  });

  grunt.loadNpmTasks('grunt-contrib-jade');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-newer');

  grunt.registerTask('default', [
    'connect',
    'less',
    'watch', 
  ]);

  grunt.event.on('watch', function(action, filepath, target) {

    // Земеняем в пути к измененному файлу jade/page на html
    // var destFilePath = filepath.replace(/jade\\page/, 'html');
    // Изменяем расширение файла
    // grunt.log.write(action + ' ------- ' + target);
    if (target == 'jade') {
      var destFilePath = filepath.replace(/jade/g, 'html');
      grunt.log.write(filepath + ' ------- ' + destFilePath);
      // 'page' task jade 
      grunt.config(['jade', 'page', 'files'], [
        {src: filepath, dest: destFilePath }
      ]);
    }


  });

};

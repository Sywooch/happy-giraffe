module.exports = function(grunt){
  var timer = require("grunt-timer");
  timer.init(grunt);


  grunt.initConfig({
    jade: {
      page: {
        files: {
          src: "new/jade/page/wysiwyg/wysiwyg.jade",
          dest: "new/html/wysiwyg/wysiwyg.html",
        },
        expand: true,
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
          ext: ".html"
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
        }
      }
    },

    
    less: {
      old: {
        files: {
          'css/common.css': ['less/all1.less'],
          'css/global.css': ['less/all2.less']
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
      newest: {
        files: {
          'new/css/all1.css': ['new/less/all1.less'] 
        },
        options: {
          compress: true,
          sourceMap: true,
          sourceMapFilename: 'new/css/all1.css.map',
          sourceMapURL: 'new/css/all1.css.map',
        }
      }
    },

    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'source/img',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'dest/img',
        }]
      }
    },
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
        tasks: ['less:old'],
        options: {
          livereload: true,
        },
      },
      less: {
        files: ['new/less/**/*.less'],
        tasks: ['less:newest'],
        options: {
          livereload: true,
        },
      },
      imagemin: {
        files: ['source/img/**/*.{png,jpg,gif}'],
        tasks: ['imagemin'],
      }
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

  grunt.registerTask('default', [
    'connect',
    'jade', 
    'less',
    'imagemin',
    'watch', 
  ]);

  grunt.event.on('watch', function(action, filepath, target) {

    // Земеняем в пути к измененному файлу jade/page на html
    // var destFilePath = filepath.replace(/jade\\page/, 'html');
    // Изменяем расширение файла
    grunt.log.write(action + ' ------- ' + target);
    if (action == 'jade') {
      var destFilePath = filepath.replace(/jade/g, 'html');
      grunt.log.write(filepath + ' ------- ' + destFilePath);
      // 'page' task jade 
      grunt.config(['jade', 'page', 'files'], [
        {src: filepath, dest: destFilePath }
      ]);
    }


  });

};

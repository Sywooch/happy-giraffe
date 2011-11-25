<?php

/**
 * Description of html5UploaderWidget
 *
 * @author Вячеслав
 * 
 * @see http://habrahabr.ru/blogs/webdev/109079/
 * 
 * Sample:
 * <code>
 * $("input[type='file']").damnUploader({
 *     url: './serverLogic.php',
 *     dropBox: $("#drop-files-here"),
 *     onAllComplete :function() {
 *         alert('ready!');
 *     }
 * });
 * </code>
 * 
 * url       - адрес, куда будут отправляться файлы ('upload.php')
 * multiple  - возможность выбора нескольких файлов (true)
 * fieldName - имитация имени поля с файлом, кторое будет ключом в $_FILES, если используется PHP ('file')
 * dropping  - вкл./выключить drag'n'drop файлов. Имеет смысл, если передается параметр dropBox (false)
 * dropBox   - jQuery-набор или селектор, содержащий контейнер, на который можно перетаскивать файлы (null)
 * limit     - максимальное допустимое кол-во файлов в очереди, если параметр multiple включен (false - неограниченно)
 */
class damnUploaderWidget extends CInputWidget
{
	public $url = '/';

	/**
	 *
	 * @var array
	 * 
	 * **********************
	 * ПРИНИМАЕМЫЕ ПАРАМЕТРЫ (в скобках - значения по умолч.):
	 * 
	 * url       - адрес, куда будут отправляться файлы ('upload.php')
	 * multiple  - возможность выбора нескольких файлов (true)
	 * fieldName - имитация имени поля с файлом, кторое будет ключом в $_FILES, если используется PHP ('file')
	 * dropping  - вкл./выключить drag'n'drop файлов. Имеет смысл, если передается параметр dropBox (false)
	 * dropBox   - jQuery-набор или селектор, содержащий контейнер, на который можно перетаскивать файлы (null)
	 * limit     - максимальное допустимое кол-во файлов в очереди, если параметр multiple включен (false - неограниченно)
	 * 
	 * **********************
	 * ОБРАБОТЧИКИ СОБЫТИЙ (в скобках - параметры, передаваемые в функцию обратного вызова):
	 * 
	 * onSelect(file - встроенный объект File)
	 * вызывается при выборе файла, если выбирается сразу несколько, 
	 * то для каждого вызывается отдельно. Если функция возвращает false, то файл не добавляется в очередь 
	 * автоматически, благодаря чему можно получить контроль над добавлением файлов, назначая каждому 
	 * свои обработчики событий onComplete и onProgress (см. метод addItem)
	 * 
	 * onLimitExceeded ()
	 * вызывается, если превышен лимит, установленный параметром limit
	 * 
	 * onAllComplete ()
	 * вызывается, когда вся очередь загружена
	 * 
	 * onComplete(successfully - true или false, data - responceText, errorCode - содержит код HTTP-ответа, либо 0 при проблеме с соединением)
	 * 
	 * **********************
	 * ОПИСАНИЕ МЕТОДОВ:
	 * 
	 * damnUploader('addItem', uploadItem)
	 * добавляет в очередь специально подготовленный объект для загрузки, 
	 * содержащий встроенный объект File и функции обратного вызова (необязательно).
	 * Метод возвращает уникальный id, присвоенный данному объекту (по которому можно, 
	 * например, отменить загрузку конкретного файла).
	 * В следующем примере перехватывается стандартное добавление файла в очередь и создается собственный объект загрузки:
	 * $("input[type='file']").damnUploader({
	 *     onSelect: function(file) {
	 *         var uploadId = this.damnUploader('addItem', {
	 *             file: file,
	 *             onProgress: function(percents) { .. Some code, updating progress info .. },
	 *             onComplete: function(successfully, data, errorCode) {
	 *                 if(successfully) {
	 *                     alert('Файл '+file.name+' загружен, полученные данные: '+data);
	 *                 } else {
	 *                     alert('Ошибка при загрузке. Код ошибки: '+errorCode); // errorCode содержит код HTTP-ответа, либо 0 при проблеме с соединением
	 *                 }
	 *             }
	 *         });
	 *         return false; // отменить стандартную обработку выбора файла
	 *     }
	 * });
	 * 
	 * damnUploader('startUpload')
	 * начать загрузку файлов
	 * 
	 * damnUploader('itemsCount')
	 * возвращает кол-во файлов в очереди
	 * 
	 * damnUploader('cancelAll')
	 * остановить все текущие загрузки и удалить все файлы из очереди
	 * 
	 * damnUploader('cancel', queueId)
	 * отменяет загрузку для файла queueId (queueId возвращается методом addItem)
	 * 
	 * damnUploader('setParam', paramsArray)
	 * изменить один, или несколько параметров. Например:
	 * myUploader.setParam({
	 *     url: 'anotherWay.php'
	 * });
	 */
	public $options = array();

	private $baseUrl;

	public function init()
	{
		$this->publishAssets();
		$this->registerClientScripts();
		
		return parent::init();
	}
	
	public function run()
	{
		$cs = Yii::app()->getClientScript();
        $cs = Y::script();
		
		list($name,$id) = $this->resolveNameID();
		
		$htmlOptions = array_merge(array(
			'id'=>$id,
		),$this->htmlOptions);
		
		if($this->model)
		{
			echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions);
		}
		else
		{
			echo CHtml::fileField($this->name, '', $htmlOptions);
		}
		echo CHtml::link('Upload','#',array('id'=>$htmlOptions['id'].'_upload'));
		
		$id = $htmlOptions['id'];
		$htmlOptions['id'] = $id.'_drop';
		
		echo CHtml::tag('div', $htmlOptions, "<ul id=\"{$id}_img_list\"></ul>", true);
		
		$js = $this->createJsCode();
        $cs->registerScript('damnUploaderWidget_'.$this->getId(), $js);
	}
	
	public function createJsCode()
	{
		list($name,$id) = $this->resolveNameID();
		
		if(isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		
		if(is_array($this->url))
		{
			$url = reset($this->url);
			unset($this->url[0]);
		}
		
		$options = array_merge($this->options,array(
			'url'=>$this->getController()->createUrl($url, $this->url),
			'dropBox'=>'js:dropBox',
			'dropping'=>true,
			'onSelect'=>'js:function(file) {
				addFileToQueue(file);
				return false;
			}',
			'onAllComplete'=>'js:function() {
				log("*** Все загрузки завершены! ***");
				imgCount = 0;
				imgSize = 0;
			}'
		));
		
		$css = '.highlighted {background: #cde;}';
		Y::script()->registerCss('highlighted', $css);
		
		$options = CJavaScript::encode($options);
		
		return "
var imgList = $('#{$id}_img_list');

// Контейнер, куда можно помещать файлы методом drag and drop
var dropBox = $('#{$id}_drop');

dropBox.bind({
	dragenter: function() {
		$(this).addClass('highlighted');
		return false;
	},
	dragover: function() {
		return false;
	},
	dragleave: function() {
		$(this).removeClass('highlighted');
		return false;
	}
});

// Счетчик всех выбранных файлов и их размера
var imgCount = 0;
var imgSize = 0;

// Стандарный input для файлов
var fileInput = $('#{$id}');                


var options = {$options};
////////////////////////////////////////////////////////////////////////////    
// Подключаем и настраиваем плагин загрузки

fileInput.damnUploader(options);    


////////////////////////////////////////////////////////////////////////////
// Вспомогательные функции

// Вывод в консоль
function log(str) {
	alert(str);
}

// Обновление progress bar'а
function updateProgress(bar, value) {
	var width = bar.width();
	var bgrValue = -width + (value * (width / 100));
	bar.attr('rel', value).css('background-position', bgrValue+'px center').text(value+'%');
}

// Отображение выбраных файлов, создание миниатюр и ручное добавление в очередь загрузки.
function addFileToQueue(file) {

	// Создаем элемент li и помещаем в него название, миниатюру и progress bar                       
	var li = $('<li/>');
	var title = $('<div/>').text(file.name+' ').appendTo(li);
	var cancelButton = $('<a/>').attr({
		href: '#cancel', 
		title: 'отменить'
	}).text('X').appendTo(title);       

	// Если браузер поддерживает выбор файлов (иначе передается специальный параметр fake,
	// обозночающий, что переданный параметр на самом деле лишь имитация настоящего File)
	if(!file.fake) {

		// Отсеиваем не картинки
		var imageType = /image.*/;
		if (!file.type.match(imageType)) {
			log('Выбранный файл не является картинкой: `'+file.name+'` (тип '+file.type+')');
			return true;
		}

		// Если разрешено только 1 файл - очищаем очередь
		if(!options.multiple)
		{
			fileInput.damnUploader('cancelAll');
			imgCount = 0;
			imgSize = 0;
			imgList.empty();
		}

		// Добавляем картинку и прогрессбар в текущий элемент списка
		var img = $('<img/>').appendTo(li);
		var pBar = $('<div/>').addClass('progress').attr('rel', '0').text('0%').appendTo(li);

		// Создаем объект FileReader и по завершении чтения файла, отображаем миниатюру и обновляем
		// инфу обо всех файлах (только в браузерах, подерживающих FileReader)
		if($.support.fileReading) {
			var reader = new FileReader();
			reader.onload = (function(aImg) {
				return function(e) {
					aImg.attr('src', e.target.result);
					aImg.attr('width', 150);                                        
				};
			})(img);
			reader.readAsDataURL(file);
		}

//		log('Картинка добавлена: `'+file.name + '` (' +Math.round(file.size / 1024) + ' Кб)');
		imgSize += file.size;
	}

	li.appendTo(imgList);

	imgCount++;        

	// Создаем объект загрузки
	var uploadItem = {
		file: file,
		onProgress: function(percents) {
			updateProgress(pBar, percents);
		},
		onComplete: function(successfully, data, errorCode) {
			if(successfully) {
				var jsono = eval('(' + data + ')');
				log(jsono.msg);
			} else {
				if(!this.cancelled) {
					log('Файл `'+this.file.name+'`: ошибка при загрузке. Код: '+errorCode);
				}
			}
		}
	};        
	
	// ... и помещаем его в очередь
	var queueId = fileInput.damnUploader('addItem', uploadItem);

	// обработчик нажатия ссылки 'отмена'
	cancelButton.click(function() {
		fileInput.damnUploader('cancel', queueId);
		li.remove();
		imgCount--;
		imgSize -= file.fake ? 0 : file.size;            
		log(file.name+' удален из очереди');
		return false;
	});

	return uploadItem;
}

////////////////////////////////////////////////////////////////////////////

// Обаботка события нажатия на кнопку 'Загрузить все'.
// стартуем все загрузки
$('#{$id}_upload').click(function() {       
	fileInput.damnUploader('startUpload');
	return false;
});

// Обработка события нажатия на кнопку 'Отменить все'
$('#{$id}_cancel').click(function() {
	fileInput.damnUploader('cancelAll');
	imgCount = 0;
	imgSize = 0;
	log('*** Все загрузки отменены ***');
	imgList.empty();
});      

";
	}


	public function publishAssets()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'source';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);
    }
	
	public function registerClientScripts()
    {
        // add the script
        $cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->baseUrl.'/jquery.damnUploader.js');
    }
}

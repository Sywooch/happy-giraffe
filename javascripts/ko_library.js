/**
 * Дополнительные часто используемые байндинги
 * Author: alexk984
 * Date: 12.08.13
 */

ko.bindingHandlers.redactorHG = {
	init: function(element, valueAccessor) {
		var value = valueAccessor();
		var wysiwyg = new HgWysiwyg(element, value.config.options, value.config.callbacks);
        var attr = value.attr;

        wysiwyg.addCallback('init', function() {
            var obj = this;
            obj.set(attr());
            attr.subscribe(function(a) {
                if(a !== obj.get()) {
                    obj.set(a);
                }
            });
        });

        wysiwyg.addCallback('change', function(html) {
            if(attr() != html) {
                attr(html);
            }
        });

        wysiwyg.run();
	}
};

ko.bindingHandlers.tooltip = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
    },
    update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        $(element).data('powertip', valueAccessor());
        $(element).powerTip({
            placement: 'n',
            smartPlacement: true,
            popupId: 'tooltipsy-im',
            offset: 8
        });
    }
};

ko.bindingHandlers.stopBinding = {
    init: function() {
        return { controlsDescendantBindings: true };
    }
};

ko.virtualElements.allowedBindings.stopBinding = true;


ko.bindingHandlers.fadeVisible = {
    init: function(element, valueAccessor) {
        var value = valueAccessor();
        $(element).toggle(ko.utils.unwrapObservable(value));
    },
    update: function(element, valueAccessor) {
        var value = valueAccessor();
        ko.utils.unwrapObservable(value) ? $(element).fadeIn(300) : $(element).fadeOut(300);
    }
};

ko.bindingHandlers.slideVisible = {
    init: function(element, valueAccessor) {
        var value = valueAccessor();
        $(element).toggle(ko.utils.unwrapObservable(value));
    },
    update: function(element, valueAccessor) {
        var value = valueAccessor();
        if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
            $(element).slideToggle(300);
    }
};

ko.bindingHandlers.toggleVisible = {
    init: function(element, valueAccessor) {
        var value = valueAccessor();
        $(element).toggle(ko.utils.unwrapObservable(value));
    },
    update: function(element, valueAccessor) {
        var value = valueAccessor();
        if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
            $(element).toggle(200);
    }
};


ko.bindingHandlers.chosen =
{
    init: function(element)
    {
        $(element).addClass('chzn');
        $(element).chosen();
    },
    update: function(element)
    {
        $(element).trigger('liszt:updated');
    }
};

ko.bindingHandlers.returnKey = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel) {
        ko.utils.registerEventHandler(element, 'keydown', function(evt) {
            if (evt.keyCode === 13) {
                evt.preventDefault();
                evt.target.blur();
                valueAccessor().call(viewModel);
            }
        });
    }
};

ko.bindingHandlers.fixScroll = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel) {
        //console.log(element, ko.unwrap(valueAccessor()));
        var self = ko.bindingHandlers.fixScroll;
        var options = valueAccessor();

        if (options.type == 'box') {
            self.initBox(element, options);
        } else {
            self.associate(element, options);
        }
    },
    initBox: function(element, options) {
        var self = ko.bindingHandlers.fixScroll;
        var box = $(element);
        var manager = options.manager;
        
        // погрешность для прилипания
        options.delta = options.delta || 20;

        if (manager.subscription !== false) {
            manager.subsription.dispose();
        }
        manager.subsription = manager.scrollTo.subscribe(function(value) {
            if (value !== false) {
                if(manager.scrollBot <= options.delta) {
                    $(element).scrollTo(self.getElementByModel(manager, value));
                }
                
                manager.scrollTo(false);
            }
        });

        // сбросим связь между моделями и домом, т.к. дом создаётся заново
        manager.elements = [];
        manager.models = [];
        
        // Прокрутим туда, где было
        box.scrollTop(box.find('>div.scroll_cont').outerHeight() - manager.scrollBot - box.height());

        // добавим событие прокрутки, оно триггерится и при обновлении нокаутом, и при ресайзе
        box.scroll(function() {
            console.log(manager);
            if(manager.fixTop) {
                box.scrollTop(manager.scrollTop);
            }
            if(manager.fixBot) {
                box.scrollTop(box.find('>div.scroll_cont').outerHeight() - manager.scrollBot - box.height());
            }
            // запомним позицию скролла
            manager.scrollTop = box.scrollTop();
            manager.scrollBot = Math.max(0, box.find('>div.scroll_cont').outerHeight() - box.scrollTop() - box.height());
        });


    },
    associate: function(element, options) {
        var i = options.manager.elements.length;
        options.manager.elements[i] = element;
        options.manager.models[i] = options.model;
    },
    getElementByModel: function(manager, model) {
        var result = false;
        var i = manager.models.indexOf(model);
        if (i >= 0) {
            result = manager.elements[i];
        }

        return result;
    },
    getModelByElement: function(manager, element) {
        var result = false;
        var i = manager.elements.indexOf(element);
        if (i >= 0) {
            result = manager.models[i];
        }

        return result;
    },
    update: function(element, valueAccessor, allBindingsAccessor, viewModel) {
        ko.unwrap(valueAccessor());
    },
    getNewManager: function() {
        return {
            fixTop: false,
            fixBot: false,
            scrollBot: 0,
            scrollTop: 0,
            setFix: function(param) {
                this.fixTop = (param === 'top');
                this.fixBot = (param === 'bot');
            },
            scrollTo: ko.observable(),
            subscription: false,
            elements: [],
            models: []
        };
    }
}

ko.bindingHandlers.autogrow = {

    init: function (element, valueAccessor, allBindingsAccessor) {
        $(element).focus(function () {
            $(element).autosize();
        });

        $(element).change(function () {
            $(element).autosize();
        });
    }
};

ko.bindingHandlers.moment = {
	presets: {
		adaptive: function(date) {
			var now = new Date().getTime();
			date = date * 1000;
			var value = date + serverTimeDelta;
			var serverDate = new Date(now - serverTimeDelta);
			var someHoursAgo = new Date(serverDate.getFullYear(), serverDate.getMonth() , serverDate.getDate(), serverDate.getHours() - 6, serverDate.getMinutes(), serverDate.getSeconds()).getTime();
			var yesterdayMidnight = new Date(serverDate.getFullYear(), serverDate.getMonth() , serverDate.getDate() - 1).getTime();
			var someMonthAgo = new Date(serverDate.getFullYear(), serverDate.getMonth() - 8 , serverDate.getDate()).getTime();
			var result = '';
			// Что-бы не получилось событие из будущего
			if(value > now)
				value = now;
			if(value > someHoursAgo) {
				result = moment(value).from(now);
			} else if(date > yesterdayMidnight) {
				result = 'Вчера';
			} else if(date > someMonthAgo) {
				result = moment(date).format('DD MMMM');
			} else {
				result = moment(date).format('DD MMMM YYYY');
			}
			return result;
		}
	},
	update: function(element, valueAccessor, allBindings) {
		var defaults = {
			timeAgo: false,
			autoUpdate: true,
			preset: 'adaptive'
		};
		var options = valueAccessor();
		
		if(!(options instanceof Object)) {
			options = {
				value: options
			}
		}
		
		var settings = $.extend( {}, defaults, options );
		
		var self = ko.bindingHandlers.moment;
		if(settings.autoUpdate) {
			self.addElement({
				config: settings,
				element: element
			});
		}
		$(element).text(self.formatDate(settings));
	},
	formatDate: function(settings) {
		var self = ko.bindingHandlers.moment;
		var result = '';
		if(settings.preset && self.presets[settings.preset]) {
			result = self.presets[settings.preset](settings.value);
		} else {
			result = moment(settings.value * 1000 + serverTimeDelta + 1000).fromNow();
		}
		
		return result;
	},
	timer: false,
	elements: new Array(),
	addElement: function(el) {
		var self = ko.bindingHandlers.moment;
		self.elements.push(el);
		if(!self.timer)
			self.timer = setInterval(self.tick, 1000);
	},
	tick: function() {
		var self = ko.bindingHandlers.moment;
		ko.utils.arrayForEach(self.elements, function(data) {
			$(data.element).text(self.formatDate(data.config));
		});
	}
}

ko.bindingHandlers.show = {
	extend: function(options) {
		var defaults = {
			selector: null,
			//timeOut: false,
			//active: true
		};
		if(typeof(options) == 'function') {
			options = {
				callback: options
			}
		}
		return $.extend( {}, defaults, options );
	},
	init: function(element, valueAccessor) {
		var settings = ko.bindingHandlers.show.extend(valueAccessor());
		$(element).on('show', settings.selector, function(event) {
			if(this == event.target) {
				settings.callback();
			}
		});
	}/*,
	update: function(element, valueAccessor) {
		var settings = this.extend(valueAccessor());

		$(element).on('show', settings.selector, function(event) {
			if(this == event.target) {
				settings.callback();
			}
		})
	},*/
}
ko.bindingHandlers.hide = {
	init: function(element, valueAccessor) {
		var defaults = {
			selector: null,
		};
		var options = valueAccessor();
		
		if(typeof(options) == 'function') {
			options = {
				callback: options
			}
		}
		
		var settings = $.extend( {}, defaults, options );
		
		$(element).on('hide', settings.selector, function(event) {
			if(this == event.target) {
				settings.callback();
			}
		});
		$(window).blur(function() {
			settings.callback();
		});
	}
}

ko.bindingHandlers.scrollTo = {
	init: function(element, valueAccessor) {
		$(element).on(valueAccessor(), function() {
			var self = $(this);
			var scroll = self.parents('.scroll_scroller');
			// Проверить формулу
			//console.log(scroll.scrollTop() + scroll.height() - (scroll.offset().top - self.offset().top + self.height()));
			//scroll.scrollTo( { top: scroll.scrollTop() + scroll.height() - (scroll.offset().top - self.offset().top + self.height()) }, 800);
		});
	}
}

// Добавляем событие koUpdate и koElementAdded
// koUpdate Срабатывает при рендере шаблона (template, with, foreach)
//		целью является элемент, в котором произошли
//		изменения (если виртуальный биндинг, то ближайщий родитель;
//		иначе - элемент в котором описан биндинг)
//		доп. аргумент в событии newElements - добавленные элементы
// koElementAdded Срабатывает для каждого добавленного элемента
//		целью является добавляемый элемент
ko.updateDOMCallback = function(element, addedElemets) {
	if (element.nodeName == '#comment' || element.nodeType == 8) {
		element = element.parentElement;
	}
	for(var i in addedElemets) {
		$(addedElemets[i]).trigger('koElementAdded');
	}
	$(element).trigger('koUpdate', addedElemets);
}

//jqAuto -- main binding (should contain additional options to pass to autocomplete)
//jqAutoSource -- the array to populate with choices (needs to be an observableArray)
//jqAutoQuery -- function to return choices
//jqAutoValue -- where to write the selected value
//jqAutoSourceLabel -- the property that should be displayed in the possible choices
//jqAutoSourceInputValue -- the property that should be displayed in the input box
//jqAutoSourceValue -- the property to use for the value
ko.bindingHandlers.jqAuto = {
    init: function(element, valueAccessor, allBindingsAccessor, viewModel) {
        var options = valueAccessor() || {},
            allBindings = allBindingsAccessor(),
            unwrap = ko.utils.unwrapObservable,
            modelValue = allBindings.jqAutoValue,
            source = allBindings.jqAutoSource,
            query = allBindings.jqAutoQuery,
            valueProp = allBindings.jqAutoSourceValue,
            inputValueProp = allBindings.jqAutoSourceInputValue || valueProp,
            labelProp = allBindings.jqAutoSourceLabel || inputValueProp;

        //function that is shared by both select and change event handlers
        function writeValueToModel(valueToWrite) {
            if (ko.isWriteableObservable(modelValue)) {
                modelValue(valueToWrite );
            } else {  //write to non-observable
                if (allBindings['_ko_property_writers'] && allBindings['_ko_property_writers']['jqAutoValue'])
                    allBindings['_ko_property_writers']['jqAutoValue'](valueToWrite );
            }
        }

        //on a selection write the proper value to the model
        options.select = function(event, ui) {
            writeValueToModel(ui.item ? ui.item.actualValue : null);
        };

        //on a change, make sure that it is a valid value or clear out the model value
        options.change = function(event, ui) {
            var currentValue = $(element).val();
            var matchingItem =  ko.utils.arrayFirst(unwrap(source), function(item) {
                return unwrap(inputValueProp ? item[inputValueProp] : item) === currentValue;
            });

            if (!matchingItem) {
                writeValueToModel(null);
            }
        }

        //hold the autocomplete current response
        var currentResponse = null;

        //handle the choices being updated in a DO, to decouple value updates from source (options) updates
        var mappedSource = ko.dependentObservable({
            read: function() {
                mapped = ko.utils.arrayMap(unwrap(source), function(item) {
                    var result = {};
                    result.label = labelProp ? unwrap(item[labelProp]) : unwrap(item).toString();  //show in pop-up choices
                    result.value = inputValueProp ? unwrap(item[inputValueProp]) : unwrap(item).toString();  //show in input box
                    result.actualValue = valueProp ? unwrap(item[valueProp]) : item;  //store in model
                    return result;
                });
                return mapped;
            },
            write: function(newValue) {
                source(newValue);  //update the source observableArray, so our mapped value (above) is correct
                if (currentResponse) {
                    currentResponse(mappedSource());
                }
            },
            disposeWhenNodeIsRemoved: element
        });

        if (query) {
            options.source = function(request, response) {
                currentResponse = response;
                query.call(this, request.term, mappedSource);
            }
        } else {
            //whenever the items that make up the source are updated, make sure that autocomplete knows it
            mappedSource.subscribe(function(newValue) {
                $(element).autocomplete("option", "source", newValue);
            });

            options.source = mappedSource();
        }


        //initialize autocomplete
        $(element).autocomplete(options);
    },
    update: function(element, valueAccessor, allBindingsAccessor, viewModel) {
        //update value based on a model change
        var allBindings = allBindingsAccessor(),
            unwrap = ko.utils.unwrapObservable,
            modelValue = unwrap(allBindings.jqAutoValue) || '',
            valueProp = allBindings.jqAutoSourceValue,
            inputValueProp = allBindings.jqAutoSourceInputValue || valueProp;

        //if we are writing a different property to the input than we are writing to the model, then locate the object
        if (valueProp && inputValueProp !== valueProp) {
            var source = unwrap(allBindings.jqAutoSource) || [];
            var modelValue = ko.utils.arrayFirst(source, function(item) {
                return unwrap(item[valueProp]) === modelValue;
            }) || {};
        }

        //update the element with the value that should be shown in the input
        $(element).val(modelValue && inputValueProp !== valueProp ? unwrap(modelValue[inputValueProp]) : modelValue.toString());
    }
};
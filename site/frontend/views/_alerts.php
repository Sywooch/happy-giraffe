<div class="ui-alert-material" id="js-alerts">
    <div class="ui-alert-material__wrapper ui-material-animated flipInX" data-bind="foreach: alertsList">
        <div class="ui-alert-material__box" data-bind="css: 'ui-alert-material__box--' + color">
            <span class="ui-alert-material__text" data-bind="text: message"></span>
            <span class="js-ui-alert-material__close ui-alert-material__close" data-bind="click: $parent.closeAlert"></span>
        </div>
    </div>
</div>
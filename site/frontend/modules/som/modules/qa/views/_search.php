<?php
/**
 * @var string $query
 */
Yii::app()->clientScript->registerAMD('qa-search', array('ko' => 'knockout', 'QaSearch' => 'qa/search'), 'ko.applyBindings(new QaSearch("' . $query . '"), $(".b-main-search").get(0));')
?>

<div class="b-main-search float-r">
    <div class="b-main-search__title">Найти вопрос</div>
    <form class="b-main-search__form" action="<?=Yii::app()->createUrl('/som/qa/default/search/')?>">
      <input type="search" placeholder="Найти вопрос" class="b-main-search__input">
      <span class="js-b-main-search__submit b-main-search__submit"></span>
      <span class="js-b-main-search__close b-main-search__close">&times;</span>
    </form>
</div>

<script type="text/javascript">
  $(function () {

      $('.js-b-main-search__submit').on('click', function () {
    	  showSearch();
      });

      $('.b-main-search__title').on('click', function () {
    	  showSearch();
      });

      function showSearch()
      {
          $('.b-main-search__input').css('display', 'block');
          $('.b-main-search__submit').css('display', 'none');
          $('.b-main-search__close').css('display', 'inline-block');
      }

      $('.js-b-main-search__close').on('click', function () {
          $('.b-main-search__input').css('display', 'none');
          $('.b-main-search__submit').css('display', 'inline-block');
          $('.b-main-search__close').css('display', 'none');
      });

  });

</script>
$(document).ready(function(){
   if ($('select').size()>0){  
      var params = {
	  	  changedEl: "select",
	  	  visRows: 8,
		 scrollArrows: true
	  }

	    cuSel(params);
   }
   $(".CheckBoxClass").change(function(){
      if($(this).is(":checked")){
         $(this).next("label").addClass("LabelSelected");
      }else{
         $(this).next("label").removeClass("LabelSelected");
      }
   });

   $(".RadioClass").change(function(){
      if($(this).is(":checked")){
         $(".RadioSelected:not(:checked)").removeClass("RadioSelected");
         $(this).next("label").addClass("RadioSelected");
      }
   });
 
    $(".RadioClass").trigger('change');
   
   $('.tr').each(function(){
     $(this).css('height', $(this).next('.peach').outerHeight() );
      
   });
});

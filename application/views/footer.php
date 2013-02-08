
  </div>
  


<script type="text/javascript" src="<?php echo asset_url()."js/jquery.js";?>" ></script>
<script type="text/javascript">

  $(window).load(function(){

    $('.code-input').focus();

    $('#regis-form').live('submit', function(){

      var code = $('.code-input').val();


      $.ajax({
        type: 'POST',
        url: "index.php/process",
        data:{ code : code },
        complete: function( msg ){

          $('.code-input').val('');
          
            
            $('.main-content').html('');
            $('.main-content').append(msg.responseText);

          
          
        }

      });

      return false;
    });

  });



</script>
  
</body>
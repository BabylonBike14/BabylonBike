// --------------------------------------------------------------------------------------------------------------------------------------------------------------------

  // function logIn
   $("#frmLog_In").submit(function(event)
   {
      // stop the normal actions of form
      event.preventDefault();

        // complete the process with ajax
        $.ajax({
          url: url + 'User/logIn',
          type: 'POST',
          data: $(this).serialize(),
        })
        .done(function(r)
        {
          if (r == 1)
          {
            // this just in case the user have shit of internet
            response = '<div class="alert alert-dismissible alert-success">';
            response += '<p><strong>ERROR</strong> Conectado!!!!...</p>';
            response += '</div>';

            $("#response").html(response);

              window.location.reload();
          }

          else
          {
            $("#response").html(r);
          }

        });
  });

  // function signIn
   $("#frmSign_In").submit(function(event)
   {
      // stop the normal actions of form
      event.preventDefault();

          // complete the process with ajax
          $.ajax({
            url: url + 'User/signIn',
            type: 'POST',
            data: $(this).serialize()
          })
          .done(function(r)
          {
             if (r == 1)
             {
               // this just in case the user have shit of internet
               response = '<div class="alert alert-dismissible alert-success">';
               response += '<p><strong>ERROR</strong> Conectado!!!!...</p>';
               response += '</div>';

               $("#responseR").html(response);

               // reload the page
               location.reload();
             }

             else
             {
               $("#responseR").html(r);
             }

          });
   });

//log out the user
function logOut()
{
  $.ajax({
    url: url + 'User/logOut',
    type: 'POST',
    data: {data: 'sd'}
  });
}

//preview img
$("#files").on('change', function()
{

    var files = $(this)[0].files.length;
    var imgPath = $(this)[0].value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    $("#imgPreview").empty();

    if (typeof(FileReader) != "undefined")
    {
      if (files > 5)
      {
        response = '<div class="alert alert-dismissible alert-warning">';
        response += '<p><strong>ERROR</strong>No images!!!!...</p>';
        response += '</div>';

          $("#message").html(response);
        $("#btnNewMeme").prop('disabled', 'true');
      }

      else
      {
        for (var i = 0; i < files; i++)
        {
          var reader = new FileReader();
          reader.onload = function (e)
          {
              $("<img />",
              {
                  "src": e.target.result,
                  "width": 110,
                  "height": 110
              }).appendTo($("#imgPreview"));
          }

          $("#imgPreview").show();
          reader.readAsDataURL($(this)[0].files[i]);
        }

        response = '<div class="alert alert-dismissible alert-success">';
        response += '<p><strong>ERROR</strong>images OK!!!!...</p>';
        response += '</div>';

          $("#message").html(response);
        $("#btnNewMeme").removeAttr('disabled');
      }
    }
});

  //load img to db
  $("#newMeme").on('submit', function(e)
  {
    e.preventDefault();

    $.ajax({
      url: url + 'Meme/newMeme',
      type: 'POST',
      contentType: false,
      mimeType: "multipart/form-data",
      cache: false,
      processData:false,
      data: new FormData($(this)[0]),

    })
    .done(function(data)
    {
      $("#responseM").html(data);
      $("#comment").val("");
      $("#imgPreview").attr('src', '');
      $("#files").wrap('<form>').closest('form').get(0).reset();
      $("#files").unwrap();
    });

    return false;
  });

function search(id)
{
  $.post(url + 'search', {data: $("#"+id).val() }, function(r)
  {
    window.location.href ="http://localhost/Final/search";
  });
  return false;
}

// change images
function changeImg(img)
  {
    var src = $("#"+ img).attr('src');
    $("#mainImg").attr('src', src);
  }

  $("#frmComment").submit(function(event)
  {
    event.preventDefault();

    $.ajax({
      cache: false,
      url: url + 'User/comment',
      type: 'POST',
      data: $(this).serialize()
    })
    .done(function(r)
    {
      $("#commentDiv").html(r);
      $("#comment").val(" ");
      window.location.reload();
    })
    .always(function() {
    });
  });

  function deleteAd(id)
  {
    $.ajax({
      url: url + 'Admin/deleteAd',
      type: 'POST',
      data: {id_meme: $("#meme" + id).val()}
    })
    .done(function(r)
    {
      window.location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }

  function deleteUser(id)
  {
    $.ajax({
      url: url + 'Admin/deleteUser',
      type: 'POST',
      data: {id_user: $("#user" + id).val()}
    })
    .done(function(r)
    {
      window.location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  $('#frmSearchProduct').on('submit', function(event)
  {
    event.preventDefault();
    $.ajax({
      url: url + 'Categories/search/Product',
      type: 'POST',
      data: $(this).serialize()
    })
    .done(function(r)
    {
      $('#r').html(r);
      window.location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  });

  $('#frmSearchBike').on('submit', function(event)
  {
    event.preventDefault();
    $.ajax({
      url: url + 'Categories/search/Bike',
      type: 'POST',
      data: $(this).serialize()
    })
    .done(function(r)
    {
      $('#r').html(r);
      window.location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  });


  // --------------------------------------------------------------------------------------------------------------------------------------------------------------------

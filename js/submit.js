const likePost = btn => {
    
    let main_post_el = btn.closest('.single-post')
    let user_id = main_post_el.querySelector("#user_id").value;
    let post_id = main_post_el.querySelector("#post_id").value;
    let num = parseInt(btn.querySelector('#span').innerText)+1
    btn.innerHTML = `<i class='fa fa-thumbs-o-up'> Likes <span id='span'>${num}</span></i>`
    btn.disabled = true;
    
      $.ajax
        ({
          type: "POST",
          url: "submitLike.php",
          data: { "user_id": user_id, "post_id": post_id },
          success: function (data) {
            $('.result').html(data);
            $('#contactform')[0].reset();
            
          }
      });
}

const commentPostSubmit = btn => {
    
    let main_post_el = btn.closest('.single-post')
    let user_id = main_post_el.querySelector("#user_id2").value;
    let post_id = main_post_el.querySelector("#post_id2").value;
    let content = main_post_el.querySelector("#content").value;
    let comm = main_post_el.querySelector('.comm');
    comm.innerHTML = `<p>Commented!!!</p>`;
    btn.disabled = true;
    
      $.ajax
        ({
          type: "POST",
          url: "submitComm.php",
          data: { "user_id": user_id, "post_id": post_id , "content": content},
          success: function (data) {
            $('.result').html(data);
            $('#contactform')[0].reset();
            
          }
      });
}

const removeMyPost = btn => {
    
    let main_post_el = btn.closest('.single-post')
    let del_post = main_post_el.querySelector("#del_post").value;
    if (confirm("Are you sure you want to delete the post?") == true) {
     $.ajax
        ({
          type: "POST",
          url: "delPost.php",
          data: { "del_post": del_post},
          success: function (data) {
            $('.result').html(data);
            $('#contactform')[0].reset();
            
          }
      });
      window.location.href = 'home.php';
    }
}

const delUser = btn => {
    
    let del_user = document.querySelector("#del_user").value;
    if (confirm("Are you sure you want to delete the profile?") == true) {
     $.ajax
        ({
          type: "POST",
          url: "delUser.php",
          data: { "del_user": del_user},
          success: function (data) {
            $('.result').html(data);
            $('#contactform')[0].reset();
            
          }
      });
    }
}

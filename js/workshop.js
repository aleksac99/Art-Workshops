function editComment(commentID) {
    var commentDiv = document.querySelector('div[id="comment-text-div-'+commentID+'"]');
    var txt = commentDiv.textContent.trim();
    commentDiv.innerHTML = "<form method='post' action=''>" +
    "<input type='hidden' name='commentID' value=" + commentID + ">" +
    "<input name='commentText' class='form-control' type='text' value='"+ txt +"'>" +
    "<input class='btn btn-link' type='submit' value='Potrvrdi izmenu' name='editComment'>" +
    "<input class='btn btn-link' type='submit' value='Obrisi komentar' name='deleteComment'>" +
    "</form>";
}

function focusComment() {
    document.getElementById("addComment").focus();
}
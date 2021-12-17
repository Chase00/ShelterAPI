/***********************************************************************************************************
 ******                            Show Posts                                                         ******
 **********************************************************************************************************/
//This function shows all posts. It gets called when a user clicks on the Post link in the nav bar.

// Pagination, sorting, and limiting are disabled
function showPosts () {
	console.log('show all messages');
    const url = baseUrl_API + '/messages';
//define AXIOS request
    axios({
        method: 'get',
        url: url,
        cache: true,
        headers: {"Authorization": "Bearer " + jwt}
    })
        .then(function (response) {
            displayPosts(response.data);
        })
        .catch(function (error) {
            handleAxiosError(error);
        });
}

//Callback function: display all posts; The parameter is a promise returned by axios request.
function displayPosts (response) {
    //console.log(response);
    let _html;
    _html =
        "<div class='content-row content-row-header'>" +
        "<div class='post-id'>Animal ID</></div>" +
        "<div class='post-create'>Animal Name</div>" +
        "<div class='post-update'>Animal Breed</div>" +
        "<div class='post-body'>Animal Cost</></div>" +

        "</div>";
    let animals = response.data;
    animals.forEach(function(animal, x){
        let cssClass = (x % 2 == 0) ? 'content-row' : 'content-row content-row-odd';
        _html += "<div class='" + cssClass + "'>" +
            "<div class='post-id'>" +
            "<span class='list-key' onclick=showComments('" + animal.id + "') title='Get post details'>" + animal.id + "</span>" +
            "</div>" +
            "<div class='post-create'>" + animal.animal_name + "</div>" +
            "<div class='post-update'>" + animal.animal_breed + "</div>" +
            "<div class='post-body'>" + animal.animal_cost + "</div>" +
            "</div>" +
            "<div class='container post-detail' id='post-detail-" + animal.id + "' style='display: none'></div>";
    });
    //Finally, update the page
    updateMain('Animals', 'All Animals', _html);
}


/***********************************************************************************************************
 ******                            Show Comments made for a message                                   ******
 **********************************************************************************************************/
/* Display all comments. It get called when a user clicks on a message's id number in
 * the message list. The parameter is the message id number.
*/
function showComments(number) {
    console.log('get a message\'s all comments');

}


// Callback function that displays all details of a course.
// Parameters: course number, a promise
function displayComments(number, response) {
    let _html = "<div class='content-row content-row-header'>Comments</div>";
    let comments = response.data;
    //console.log(number);
    //console.log(comments);
    comments.forEach(function(comment, x){
        _html +=
            "<div class='post-detail-row'><div class='post-detail-label'>Comment ID</div><div class='post-detail-field'>" + comment.id + "</div></div>" +
            "<div class='post-detail-row'><div class='post-detail-label'>Comment Body</div><div class='post-detail-field'>" + comment.body + "</div></div>" +
            "<div class='post-detail-row'><div class='post-detail-label'>Create Time</div><div class='post-detail-field'>" + comment.created_at + "</div></div>";
    });

    $('#post-detail-' + number).html(_html);
    $("[id^='post-detail-']").each(function(){   //hide the visible one
        $(this).not("[id*='" + number + "']").hide();
    });

    $('#post-detail-' + number).toggle();
}


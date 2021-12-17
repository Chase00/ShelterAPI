function showAnimals () {
    console.log('show all animals');

}

//Callback function: display all posts; The parameter is a promise returned by axios request.
function displayAnimals (response) {
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

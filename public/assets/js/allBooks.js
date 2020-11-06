$(function() {
    $("#modal-default").on("show.bs.modal", event => {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var title = button.data("title"); // Extract info from data-* attributes
        var id = button.data("id"); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // modal.find('.modal-title').text(title);
        $( "#modal-default .modal-title" ).text( title );
        var url = button.data( "archive" ) == true ? `/get-archive-book/${ id }` : `/get-book/${ id }`;
        $.get(url, function(data) {
            // console.log(data );
            //Setting timeout for query
            setTimeout(() => {
                $("#modal-default .modal-body").html(`
                   <div class="">
                        <div class="table-responsive">
                            <table class="table table-striped align-items-center">
                                <tbody class="">
                                    <tr>
                                        <th scope="row">Title:</th>
                                        <td>${data.title}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Author</th>
                                        <td>${data.author}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Editor</th>
                                        <td>${data.editor}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Publisher</th>
                                        <td>${data.publisher}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Place of Publication</th>
                                        <td>${data.place_of_publication}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Copyright Date</th>
                                        <td>${data.copyright_date}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Edition</th>
                                        <td>${data.edition}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Category</th>
                                        <td>${data.category}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Language</th>
                                        <td>${data.language}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Create</th>
                                        <td>${new Date(data.created_at)}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Last Updated</th>
                                        <td>${new Date(data.updated_at)}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                   </div>
                `);
            }, 3000);
        });
    });

    //refersh the modal on close
    $("#modal-default").on("hidden.bs.modal", function(e) {
        $("#modal-default .modal-body").html(`
            <div class="text-center">
                <img src="/assets/img/loader/rotate_img.gif" class="img-fluid " alt="loading">
            </div>
        `);
        $(e.target).removeData("bs.modal");
    });
});

$(document).ready(function() {
    $('.ebaybrick .expert').click(function(e) {
        e.stopPropagation();
        var id = $(this).attr('data-id');
        $.post('/manage/getExpertComment', {
            itemid: id,
            type: 'ebay'
        }, function(response) {
            if (response.success) {
                comments = response.comments;
            } else {
                comments = {
                    'shortcomment': '',
                    'longcomment': ''
                };
            }
            bootbox.dialog({
                title: "Add Expert Comment",
                message: `
                    <form id="expertform">
                        <input type="hidden" name="type" value="ebay"/>
                        <input type="hidden" name="itemid" value="${id}"/>
                        <fieldset class="form-group">
                            <label for="shortcomment">Short Comment</label>
                            <textarea class="form-control" name="shortcomment" maxlength="500">${comments["shortcomment"]}</textarea>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="longcomment">Long Comment</label>
                            <textarea class="form-control" name="longcomment">${comments["longcomment"]}</textarea>
                        </fieldset>
                    </form>
                    <script>
                    $('textarea[name="longcomment"]').summernote({
                        disableDragAndDrop: true,
                        height: 150,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']]
                        ],
                        popover: {
                            image: [],
                            link: [],
                            air: []
                        }
                    });
                    </script>
                `,
                buttons: {
                    submit: {
                        label: 'Submit',
                        callback: function() {
                            $.post(
                                '/manage/addExpertComment',
                                $(
                                    '#expertform'
                                ).serialize(),
                                function(
                                    response
                                ) {
                                    if (
                                        response
                                        .success
                                    ) {} else {}
                                },
                                'json');
                        }
                    }
                }
            });
        }, 'json');
    });
    $('.itembrick .expert').click(function(e) {
        e.stopPropagation();
        var id = $(this).attr('data-id');
        $.post('/manage/getExpertComment', {
            itemid: id,
            type: 'ikeio'
        }, function(response) {
            if (response.success) {
                comments = response.comments;
            } else {
                comments = {
                    'shortcomment': '',
                    'longcomment': ''
                };
            }
            bootbox.dialog({
                title: "Add Expert Comment",
                message: `
                    <form id="expertform">
                        <input type="hidden" name="type" value="ikeio"/>
                        <input type="hidden" name="itemid" value="${id}"/>
                        <fieldset class="form-group">
                            <label for="shortcomment">Short Comment</label>
                            <textarea class="form-control" name="shortcomment" maxlength="500">${comments["shortcomment"]}</textarea>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="longcomment">Long Comment</label>
                            <textarea class="form-control" name="longcomment">${comments["longcomment"]}</textarea>
                        </fieldset>
                    </form>
                    <script>
                    $('textarea[name="longcomment"]').summernote({
                        disableDragAndDrop: true,
                        height: 150,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']]
                        ],
                        popover: {
                            image: [],
                            link: [],
                            air: []
                        }
                    });
                    </script>
                `,
                buttons: {
                    submit: {
                        label: 'Submit',
                        callback: function() {
                            $.post(
                                '/manage/addExpertComment',
                                $(
                                    '#expertform'
                                ).serialize(),
                                function(
                                    response
                                ) {
                                    if (
                                        response
                                        .success
                                    ) {} else {}
                                },
                                'json');
                        }
                    }
                }
            });
        }, 'json');
    });
});

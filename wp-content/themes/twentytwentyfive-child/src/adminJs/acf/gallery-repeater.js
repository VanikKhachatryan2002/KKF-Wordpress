jQuery(document).ready(function($) {
    var frame;
    $('.add_gallery_image').on('click', function(e) {
        e.preventDefault();
        if (frame) {
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'Select Images',
            button: { text: 'Add Images' },
            multiple: true
        });

        frame.on('select', function() {
            var selection = frame.state().get('selection');
            var index = $('.gallery-item').length;
            selection.each(function(attachment) {
                var thumb_url = attachment.attributes.sizes.thumbnail.url;
                var img_id = attachment.id;
                var item = `
                    <li class="gallery-item">
                        <input type="hidden" name="custom_gallery[${index}]" value="${img_id}">
                        <img src="${thumb_url}" />
                        <a href="#" class="remove-gallery-item">Remove</a>
                    </li>
                `;
                $('.gallery-preview').append(item);
                index++;
            });
        });

        frame.open();
    });

    $(document).on('click', '.remove-gallery-item', function(e) {
        e.preventDefault();
        $(this).closest('.gallery-item').remove();
    });
});

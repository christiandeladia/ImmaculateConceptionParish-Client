var numArticle = 0;

$('.add-article').click(function () {
    var current = $(this);
    var currentParent = current.parents('.article-box');
    var currentImage = currentParent.find('.article-img');

    var currentClone = currentImage.clone();
    currentClone.removeClass('article-img'); // Remove the article-img class

    // Apply the same styling as the original image
    currentClone.css({
        // bottom: '200px',
        width: '12%', // Add this line to set the width to 100%
        position: 'absolute', // Add this line to set the position to absolute
        top: currentImage.offset().top,
        left: currentImage.offset().left
    });

    currentClone.addClass('animation-cart');
    currentClone.appendTo('body');

    var topCart = $('.header-cart').offset().top;
    var LeftCart = $('.header-cart').offset().left;
    numArticle++;

    setTimeout(function () {
        $('.header-cart').addClass('shake');
        currentClone.animate({
            top: topCart - 130,
            left: LeftCart - 140
        }, 1200);
    }, 600);

    setTimeout(function () {
        $('.header-cart span').html(numArticle);
    }, 1800);

    setTimeout(function () {
        $('.header-cart').removeClass('shake');
        currentClone.remove();
        
        // Submit the form after the animation is complete
        form.submit();
    }, 2200);
});

function copyText(element)
{
    navigator.clipboard.writeText(element.textContent);
    alert('Tracking number copied!');
}

function changeMainImage(element)
{
    const img = element.firstElementChild;
    const main_img = document.getElementById('main-image');
    main_img.parentElement.href = img.src;
    main_img.src = img.src;
    main_img.alt = img.alt;
}

function showImage(is_next)
{
    const carousel_images = document.getElementsByClassName('carousel-img');

    Object.values(carousel_images).forEach(element => {
        element.alt = nextAlt(element);
        element.src = product_images[element.alt];
    });

    function nextAlt(element)
    {
        let alt = Number(element.alt);
        alt = is_next ? (alt + 1) : (alt - 1);

        if(alt > product_images.length - 1)
        {
            alt = 0;
        }
        if(alt < 0)
        {
            alt = product_images.length - 1;
        }
        return alt;
    }
}
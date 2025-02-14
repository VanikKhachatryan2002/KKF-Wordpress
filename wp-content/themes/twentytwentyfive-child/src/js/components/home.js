import DeviceHelper from '../helpers/DeviceHelper';

let lastScrollTop = 0;

if (DeviceHelper.isMobile()) {
    window.addEventListener('scroll', function() {
        const works = document.querySelectorAll('.work');
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        works.forEach(work => {
            const contentOffsetTop = work.offsetTop;
            const hoverCategory = work.querySelector('.hoverCategory'); // Find hoverCategory inside work

            if (scrollTop > contentOffsetTop - 0 && scrollTop < contentOffsetTop + 400) {
                hoverCategory.style.display = 'flex';
            }else{
                hoverCategory.style.display = 'none';
            }
        });

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
}

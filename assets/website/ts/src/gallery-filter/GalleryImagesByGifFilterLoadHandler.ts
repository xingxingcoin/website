import GalleryImagesByGifFilterLoader from './GalleryImagesByGifFilterLoader';
import GalleryImagesByNoFilterLoader from './GalleryImagesByNoFilterLoader';

export default class GalleryImagesByGifFilterLoadHandler {
    private gifFilterButton: HTMLElement;
    private galleryContainer: Element;
    private galleryImagesByGifFilterLoader: GalleryImagesByGifFilterLoader;
    private galleryImagesByNoFilterLoader: GalleryImagesByNoFilterLoader;

    constructor() {
        this.gifFilterButton = document.getElementById('xing-media-gifs-filter-button');
        this.galleryContainer = document.querySelector('.xing-media-container');
        this.galleryImagesByGifFilterLoader = new GalleryImagesByGifFilterLoader();
        this.galleryImagesByNoFilterLoader = new GalleryImagesByNoFilterLoader();
        this.initEventListener();
    }

    private initEventListener(): void {
        this.gifFilterButton.addEventListener('click', (): void => {
            if (this.gifFilterButton.classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if (this.gifFilterButton.classList.contains('xing-media-filter-button')) {
                this.deleteAllImageHtmlElements();
                this.galleryImagesByGifFilterLoader.load();
            } else {
                this.deleteAllImageHtmlElements();
                this.galleryImagesByNoFilterLoader.load();
            }
        })
    }

    private deleteAllImageHtmlElements(): void {
        Array.from(this.galleryContainer.children).forEach((child: HTMLElement): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                this.galleryContainer.removeChild(child);
            }
        });
    }
}

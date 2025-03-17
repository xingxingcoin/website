import GalleryImagesByNoFilterLoader from './GalleryImagesByNoFilterLoader';
import GalleryImagesByImageFilterLoader from './GalleryImagesByImageFilterLoader';

export default class GalleryImagesByImageFilterLoadHandler {
    private imageFilterButton: HTMLElement;
    private galleryContainer: Element;
    private galleryImagesByImageFilterLoader: GalleryImagesByImageFilterLoader;
    private galleryImagesByNoFilterLoader: GalleryImagesByNoFilterLoader;

    constructor() {
        this.imageFilterButton = document.getElementById('xing-media-images-filter-button');
        this.galleryContainer = document.querySelector('.xing-media-container');
        this.galleryImagesByImageFilterLoader = new GalleryImagesByImageFilterLoader();
        this.galleryImagesByNoFilterLoader = new GalleryImagesByNoFilterLoader();
        this.initEventListener();
    }

    private initEventListener(): void {
        this.imageFilterButton.addEventListener('click', (): void => {
            if (this.imageFilterButton.classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if (this.imageFilterButton.classList.contains('xing-media-filter-button')) {
                this.displayImageButtonAsSelected();
                this.deleteAllImageHtmlElements();
                this.galleryImagesByImageFilterLoader.load();
            } else {
                this.displayImageButtonAsNotSelected();
                this.deleteAllImageHtmlElements();
                this.galleryImagesByNoFilterLoader.load();
            }
        })
    }

    private displayImageButtonAsSelected(): void {
        this.imageFilterButton.classList.remove('xing-media-filter-button');
        this.imageFilterButton.classList.add('xing-media-filter-button-selected');
    }

    private displayImageButtonAsNotSelected(): void {
        this.imageFilterButton.classList.remove('xing-media-filter-button-selected');
        this.imageFilterButton.classList.add('xing-media-filter-button');
    }

    private deleteAllImageHtmlElements(): void {
        Array.from(this.galleryContainer.children).forEach((child: HTMLElement): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                this.galleryContainer.removeChild(child);
            }
        });
    }
}

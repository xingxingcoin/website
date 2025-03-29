import GalleryImagesByGifFilterLoader from './GalleryImagesByGifFilterLoader';
import GalleryImagesByNoFilterLoader from './GalleryImagesByNoFilterLoader';

export default class GalleryImagesByGifFilterLoadHandler {
    private readonly gifFilterButton: HTMLAnchorElement | null;
    private readonly galleryContainer: Element | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesByGifFilterLoader: GalleryImagesByGifFilterLoader,
        private readonly galleryImagesByNoFilterLoader: GalleryImagesByNoFilterLoader,
        gifFilterButtonId: string,
        galleryContainerClass: string
    ) {
        this.gifFilterButton = document.getElementById(gifFilterButtonId) as HTMLAnchorElement | null;
        this.galleryContainer = document.querySelector(galleryContainerClass);
        if (this.gifFilterButton === null ||
            this.galleryContainer === null
        ) {
            throw new Error('Gallery images by gif filter not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.gifFilterButton as HTMLAnchorElement).addEventListener('click', (): void => {
            if ((this.gifFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if ((this.gifFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button')) {
                this.deleteAllImageHtmlElements();
                this.galleryImagesByGifFilterLoader.load();
            } else {
                this.deleteAllImageHtmlElements();
                this.galleryImagesByNoFilterLoader.load();
            }
        })
    }

    private deleteAllImageHtmlElements(): void {
        Array.from((this.galleryContainer as Element).children).forEach((child: any): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                (this.galleryContainer as Element).removeChild(child);
            }
        });
    }
}

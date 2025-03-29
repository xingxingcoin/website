import GalleryImagesByNoFilterLoader from './GalleryImagesByNoFilterLoader';
import GalleryImagesByImageFilterLoader from './GalleryImagesByImageFilterLoader';

export default class GalleryImagesByImageFilterLoadHandler {
    private readonly imageFilterButton: HTMLAnchorElement | null;
    private readonly galleryContainer: Element | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesByImageFilterLoader: GalleryImagesByImageFilterLoader,
        private readonly galleryImagesByNoFilterLoader: GalleryImagesByNoFilterLoader,
        imageFilterButtonId: string,
        galleryContainerClass: string
    ) {
        this.imageFilterButton = document.getElementById(imageFilterButtonId) as HTMLAnchorElement | null;
        this.galleryContainer = document.querySelector(galleryContainerClass);
        if (this.imageFilterButton === null ||
            this.galleryContainer === null
        ) {
            throw new Error('Gallery images by image filter not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.imageFilterButton as HTMLAnchorElement).addEventListener('click', (): void => {
            if ((this.imageFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if ((this.imageFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button')) {
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
        (this.imageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button');
        (this.imageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-selected');
    }

    private displayImageButtonAsNotSelected(): void {
        (this.imageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-selected');
        (this.imageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
    }

    private deleteAllImageHtmlElements(): void {
        Array.from((this.galleryContainer as Element).children).forEach((child: any): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                (this.galleryContainer as Element).removeChild(child);
            }
        });
    }
}

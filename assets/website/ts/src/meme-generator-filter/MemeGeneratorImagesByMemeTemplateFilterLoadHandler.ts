import MemeGeneratorImagesByNoFilterLoader from './MemeGeneratorImagesByNoFilterLoader';
import MemeGeneratorImagesByMemeTemplateFilterLoader from './MemeGeneratorImagesByMemeTemplateFilterLoader';

export default class MemeGeneratorImagesByMemeTemplateFilterLoadHandler {
    private readonly memeTemplateFilterButton: HTMLAnchorElement | null;
    private readonly memeGeneratorContainer: Element | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly memeGeneratorImagesByMemeTemplateFilterLoader: MemeGeneratorImagesByMemeTemplateFilterLoader,
        private readonly memeGeneratorImagesByNoFilterLoader: MemeGeneratorImagesByNoFilterLoader,
        memeTemplateFilterButtonId: string,
        memeGeneratorContainerClass: string
    ) {
        this.memeTemplateFilterButton = document.getElementById(memeTemplateFilterButtonId) as HTMLAnchorElement | null;
        this.memeGeneratorContainer = document.querySelector(memeGeneratorContainerClass);
        if (this.memeTemplateFilterButton === null ||
            this.memeGeneratorContainer === null
        ) {
            throw new Error('Meme generator images by meme template filter not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.memeTemplateFilterButton as HTMLAnchorElement).addEventListener('click', (): void => {
            if ((this.memeTemplateFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if ((this.memeTemplateFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button')) {
                this.displayMememTemplateFilterButtonAsSelected();
                this.deleteAllImageHtmlElements();
                this.memeGeneratorImagesByMemeTemplateFilterLoader.load();
            } else {
                this.displayImageButtonAsNotSelected();
                this.deleteAllImageHtmlElements();
                this.memeGeneratorImagesByNoFilterLoader.load();
            }
        })
    }

    private displayMememTemplateFilterButtonAsSelected(): void {
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button');
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-selected');
    }

    private displayImageButtonAsNotSelected(): void {
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-selected');
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
    }

    private deleteAllImageHtmlElements(): void {
        Array.from((this.memeGeneratorContainer as Element).children).forEach((child: any): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                (this.memeGeneratorContainer as Element).removeChild(child);
            }
        });
    }
}

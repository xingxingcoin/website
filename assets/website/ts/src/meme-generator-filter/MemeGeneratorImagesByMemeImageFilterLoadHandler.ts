import MemeGeneratorImagesByMemeImageFilterLoader from './MemeGeneratorImagesByMemeImageFilterLoader';
import MemeGeneratorImagesByNoFilterLoader from './MemeGeneratorImagesByNoFilterLoader';

export default class MemeGeneratorImagesByMemeImageFilterLoadHandler {
    private readonly memeImageFilterButton: HTMLAnchorElement | null;
    private readonly memeGeneratorContainer: Element | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly memeGeneratorImagesByMemeImageFilterLoader: MemeGeneratorImagesByMemeImageFilterLoader,
        private readonly memeGeneratorImagesByNoFilterLoader: MemeGeneratorImagesByNoFilterLoader,
        memeImageFilterButtonId: string,
        memeGeneratorContainerClass: string
    ) {
        this.memeImageFilterButton = document.getElementById(memeImageFilterButtonId) as HTMLAnchorElement | null;
        this.memeGeneratorContainer = document.querySelector(memeGeneratorContainerClass);
        if (this.memeImageFilterButton === null ||
            this.memeGeneratorContainer === null
        ) {
            throw new Error('Meme generator images by meme image filter not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.memeImageFilterButton as HTMLAnchorElement).addEventListener('click', (): void => {
            if ((this.memeImageFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button-disabled')) {
                return;
            }

            if ((this.memeImageFilterButton as HTMLAnchorElement).classList.contains('xing-media-filter-button')) {
                this.deleteAllImageHtmlElements();
                this.memeGeneratorImagesByMemeImageFilterLoader.load();
            } else {
                this.deleteAllImageHtmlElements();
                this.memeGeneratorImagesByNoFilterLoader.load();
            }
        })
    }

    private deleteAllImageHtmlElements(): void {
        Array.from((this.memeGeneratorContainer as Element).children).forEach((child: any): void => {
            if (!child.classList.contains('lds-dual-ring')) {
                (this.memeGeneratorContainer as Element).removeChild(child);
            }
        });
    }
}

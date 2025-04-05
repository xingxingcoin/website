export default class MemeCanvasWithoutBackgroundCreater {
    private readonly memeTemplateImage: HTMLImageElement | null;
    private readonly memePreviewContainer: HTMLDivElement | null;

    /**
     * @exception Error
     */
    constructor(
        memeTemplateImageSelector: string,
        private readonly memePreviewContainerId: string
    ) {
        this.memeTemplateImage = document.querySelector(memeTemplateImageSelector);
        this.memePreviewContainer = document.getElementById(this.memePreviewContainerId) as HTMLDivElement;
        if (this.memePreviewContainer === null || this.memeTemplateImage === null) {
            throw new Error('Meme canvas without background could not be created.');
        }
    }

    /**
     * @exception Error
     */
    public create(): void {
        let canvas: HTMLCanvasElement = document.createElement('canvas');
        let context: CanvasRenderingContext2D | null = canvas.getContext('2d');
        if (context === null) {
            throw new Error('Meme canvas without background could not be created.');
        }

        canvas.width = (this.memeTemplateImage as HTMLImageElement).naturalWidth;
        canvas.height = (this.memeTemplateImage as HTMLImageElement).naturalHeight;
        context.drawImage((this.memeTemplateImage as HTMLImageElement), 0, 0);

        (this.memePreviewContainer as HTMLElement).innerHTML = '';

        const canvasDiv: HTMLDivElement = document.createElement('div');
        canvasDiv.appendChild(canvas);
        (this.memePreviewContainer as HTMLElement).appendChild(canvasDiv);
    }
}

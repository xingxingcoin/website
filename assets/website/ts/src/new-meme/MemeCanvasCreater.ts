import Cropper from 'cropperjs';

export default class MemeCanvasCreater {
    private readonly memePreviewContainer: HTMLDivElement | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly cropper: Cropper,
        private readonly backgroundImageByFileReader: HTMLImageElement,
        private readonly memeTemplateImage: HTMLImageElement,
        private readonly memePreviewContainerId: string,
    ) {
        this.memePreviewContainer = document.getElementById(
            this.memePreviewContainerId,
        ) as HTMLDivElement;
        if (this.memePreviewContainer === null) {
            throw new Error('Meme canvas could not be created.');
        }
    }

    /**
     * @exception Error
     */
    public create(): void {
        let canvas: HTMLCanvasElement = document.createElement('canvas');
        let context: CanvasRenderingContext2D | null = canvas.getContext('2d');
        if (context === null) {
            throw new Error('Meme canvas could not be created.');
        }

        let newMemeImageWidth: number = this.cropper.getData().width;
        let newMemeImageHeight: number = this.cropper.getData().height;
        let newMemeImagePositionY: number = this.cropper.getData().y;
        let newMemeImagePositionX: number = this.cropper.getData().x;
        let backgroundImageWidth: number = this.cropper.getImageData().naturalWidth;
        let backgroundImageHeight: number = this.cropper.getImageData().naturalHeight;

        canvas.width = backgroundImageWidth;
        canvas.height = backgroundImageHeight;
        context.imageSmoothingEnabled = true;
        context.drawImage(
            this.backgroundImageByFileReader,
            0,
            0,
            backgroundImageWidth,
            backgroundImageHeight,
        );
        context.drawImage(
            this.memeTemplateImage,
            newMemeImagePositionX,
            newMemeImagePositionY,
            newMemeImageWidth,
            newMemeImageHeight,
        );

        (this.memePreviewContainer as HTMLElement).innerHTML = '';

        const canvasDiv: HTMLDivElement = document.createElement('div');
        canvasDiv.appendChild(canvas);
        (this.memePreviewContainer as HTMLElement).appendChild(canvasDiv);
    }
}

import MemeFileDownloader from './MemeFileDownloader';

export default class MemeImageDownloadHandler {
    private readonly downloadButton: HTMLLabelElement | null;
    private readonly memeTextColorPicker: HTMLInputElement | null;
    private readonly memeTextSizeInput: HTMLInputElement | null;

    /**
     * @exception Error
     */
    constructor(private readonly memeFileDownloader: MemeFileDownloader, downloadButtonId: string, memeColorPickerInputClass: string, memeFontSizeNumberInputClass: string) {
        this.downloadButton = document.getElementById(downloadButtonId) as HTMLLabelElement | null;
        this.memeTextColorPicker = document.querySelector(memeColorPickerInputClass) as HTMLInputElement | null;
        this.memeTextSizeInput = document.querySelector(memeFontSizeNumberInputClass) as HTMLInputElement | null;
        if (this.downloadButton === null ||
            this.memeTextSizeInput === null ||
            this.memeTextColorPicker === null) {
            throw new Error('Meme image image could not be downloaded.');
        }

        this.initEventListener();
    }

    /**
     * @exception Error
     */
    private initEventListener(): void {
        (this.downloadButton as HTMLLabelElement).addEventListener('click', (): void => {
            const memeImageCanvas: HTMLCanvasElement | null = document.querySelector('#meme-preview-container div canvas');
            const memeText: HTMLParagraphElement | null = document.querySelector('#meme-preview-container div p');
            let memeCanvas: HTMLCanvasElement | null = memeImageCanvas;
            if (memeText !== null) {
                memeCanvas = this.generateCanvasWithText(memeImageCanvas, memeText);
            }
            this.memeFileDownloader.download(memeCanvas);
        });
    }

    /**
     * @exception Error
     */
    private generateCanvasWithText(memeImageCanvas: HTMLCanvasElement, memeText: HTMLParagraphElement): HTMLCanvasElement {
        const memeCanvas: HTMLCanvasElement = document.createElement('canvas');
        const context: CanvasRenderingContext2D | null = memeCanvas.getContext('2d');
        if (context === null) {
            return;
        }
        const memeCanvasContainer = document.querySelector('#meme-preview-container div') as HTMLDivElement;
        const memeCanvasContainerRect: DOMRect = memeCanvasContainer.getBoundingClientRect();
        const memeTextRect: DOMRect = memeText.getBoundingClientRect();

        const fontSize: number = parseInt((this.memeTextSizeInput as HTMLInputElement).value, 10);
        const memeTextPositionX: number = (memeTextRect.x - memeCanvasContainerRect.x) + fontSize;
        const memeTextPositionY: number = (memeTextRect.y - memeCanvasContainerRect.y) + fontSize;

        memeCanvas.width = memeCanvasContainerRect.width;
        memeCanvas.height = memeCanvasContainerRect.height;
        context.font = `${fontSize}px Impact`;
        context.fillStyle = (this.memeTextColorPicker as HTMLInputElement).value;
        context.textAlign = 'center';
        context.strokeStyle = 'black';
        context.lineWidth = 2;
        context.letterSpacing = '1px';
        context.drawImage(memeImageCanvas, 0, 0, memeCanvasContainerRect.width, memeCanvasContainerRect.height);
        context.fillText(memeText.textContent.toUpperCase(), memeTextPositionX, memeTextPositionY);
        context.strokeText(memeText.textContent.toUpperCase(), memeTextPositionX, memeTextPositionY);

        return memeCanvas;
    }
}

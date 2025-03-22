import MemeFileDownloader from './MemeFileDownloader';

export default class MemeImageDownloadHandler {
    private readonly downloadButton: HTMLElement;
    private readonly memeFileDownloader: MemeFileDownloader;

    constructor() {
        this.downloadButton = document.getElementById('new-meme-download-button');
        this.memeFileDownloader = new MemeFileDownloader();
        this.initEventListener();
    }

    private initEventListener(): void {
        this.downloadButton.addEventListener('click', (): void => {
            const memeImageCanvas: HTMLCanvasElement = document.querySelector('#meme-preview-container div canvas');
            const memeText: HTMLParagraphElement = document.querySelector('#meme-preview-container div p');
            let memeCanvas: HTMLCanvasElement = memeImageCanvas;
            if (memeText !== null) {
                memeCanvas = this.generateCanvasWithText(memeImageCanvas, memeText);
            }
            this.memeFileDownloader.download(memeCanvas);
        });
    }

    private generateCanvasWithText(memeImageCanvas: HTMLCanvasElement, memeText: HTMLParagraphElement): HTMLCanvasElement {
        const memeCanvas: HTMLCanvasElement = document.createElement('canvas');
        const context: CanvasRenderingContext2D = memeCanvas.getContext('2d');
        const memeCanvasContainer = document.querySelector('#meme-preview-container div') as HTMLDivElement;
        const memeCanvasContainerRect: DOMRect = memeCanvasContainer.getBoundingClientRect();
        const memeTextRect: DOMRect = memeText.getBoundingClientRect();

        const fontSize: number = 50;
        const memeTextPositionX: number = (memeTextRect.x - memeCanvasContainerRect.x) + fontSize;
        const memeTextPositionY: number = (memeTextRect.y - memeCanvasContainerRect.y) + fontSize;

        memeCanvas.width = memeCanvasContainerRect.width;
        memeCanvas.height = memeCanvasContainerRect.height;
        context.font = `${fontSize}px Impact`;
        context.fillStyle = 'white';
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

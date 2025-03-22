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
            const memeCanvas: HTMLCanvasElement = document.querySelector('#meme-preview-container div canvas');
            const memeText: HTMLParagraphElement = document.querySelector('#meme-preview-container div p');
            this.generateCanvasWithText(memeCanvas, memeText);
            //this.memeFileDownloader.download(this.generateCanvasWithText(memeCanvas, memeText));
        });
    }

    private generateCanvasWithText(memeCanvas: HTMLCanvasElement, memeText: HTMLParagraphElement): HTMLCanvasElement {
        let context: CanvasRenderingContext2D = memeCanvas.getContext('2d');
        const memeCanvasContainer = document.querySelector('#meme-preview-container div') as HTMLDivElement;
        const memeCanvasContainerRect: DOMRect = memeCanvasContainer.getBoundingClientRect();
        const memeTextRect: DOMRect = memeText.getBoundingClientRect();

        const fontSize: number = Math.min(memeCanvas.width, memeCanvas.height) / 6;
        const memeTextPositionX: number = (memeTextRect.x - memeCanvasContainerRect.x) * (memeCanvas.width / memeCanvasContainerRect.width) + fontSize;
        const memeTextPositionY: number = (memeTextRect.y - memeCanvasContainerRect.y) * (memeCanvas.height / memeCanvasContainerRect.height) + fontSize;

        context.font = `${fontSize}px Impact`;
        context.fillStyle = 'white';
        context.textAlign = 'center';
        context.strokeStyle = 'black';
        context.lineWidth = fontSize / 6;
        context.letterSpacing = '1px';
        context.strokeText(memeText.textContent.toUpperCase(), memeTextPositionX, memeTextPositionY);
        context.fillText(memeText.textContent.toUpperCase(), memeTextPositionX, memeTextPositionY);

        return memeCanvas;
    }
}

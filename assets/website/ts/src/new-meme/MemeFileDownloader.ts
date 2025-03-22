export default class MemeFileDownloader {
    public download(memeCanvas: HTMLCanvasElement): void {
        memeCanvas.toBlob((blob: Blob): void => {
            const url: string = URL.createObjectURL(blob);
            const link: HTMLAnchorElement = document.createElement('a');
            link.href = url;
            link.download = 'xing-meme.png';
            link.click();
            URL.revokeObjectURL(url);
        }, 'image/png');
    }
}

export default class MemeFileDownloader {
    public download(memeCanvas: HTMLCanvasElement): void {
        memeCanvas.toBlob((blob: Blob|null): void => {
            const url: string = URL.createObjectURL(blob as Blob);
            const link: HTMLAnchorElement = document.createElement('a');
            link.href = url;
            link.download = 'xing-meme.png';
            link.click();
            URL.revokeObjectURL(url);
        }, 'image/png');
    }
}

export default class MemeFileDownloader {
    public download(memeCanvas: HTMLCanvasElement): void {
        memeCanvas.toBlob((blob: Blob | null): void => {
            if (!blob) {
                return;
            }

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'xing-meme.png';
            link.click();
            URL.revokeObjectURL(url);
        }, 'image/png');
    }
}

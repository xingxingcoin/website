export default class MemeFileDownloader {
    public download(memeCanvas: HTMLCanvasElement) {
        memeCanvas.toBlob((blob: Blob | null) => {
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

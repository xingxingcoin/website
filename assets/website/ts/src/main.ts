import MemeFileByInputReader from './meme-generator/MemeFileByInputReader';

new MemeFileByInputReader();




/*function downloadImage() {
    this.memeCanvas.toBlob((blob: Blob | null) => {
        if (!blob) return;

        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'meme.png';
        link.click();
        URL.revokeObjectURL(url);
    }, 'image/png');
}
*/

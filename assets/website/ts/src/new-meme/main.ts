import BackgroundImageFileHandler from './BackgroundImageFileHandler';
import MemeTextCreater from './MemeTextCreater';
import MemeImageDownloadHandler from './MemeImageDownloadHandler';
import BackgroundImageCropperCreater from './BackgroundImageCropperCreater';
import MemeFileDownloader from "./MemeFileDownloader";
import BackgroundImageFileInputRemover from "./BackgroundImageFileInputRemover";

new BackgroundImageFileHandler(
    'background-image-selector',
    new FileReader(),
    new BackgroundImageCropperCreater(
        'new-meme-download-button',
        'new-meme-select-text-button',
        'meme-preview-container',
        '.new-meme-text-input',
        '.new-meme-input-color-picker',
        '.new-meme-input-font-size-number',
        new Image(),
        new BackgroundImageFileInputRemover(
            'background-image-selector'
        )
    ),
    new BackgroundImageFileInputRemover(
        'background-image-selector'
    )
);
new MemeTextCreater(
    '.new-meme-text-input',
    '.new-meme-input-color-picker',
    '.new-meme-input-font-size-number'
);
new MemeImageDownloadHandler(
    new MemeFileDownloader(),
    'new-meme-download-button',
    '.new-meme-input-color-picker',
    '.new-meme-input-font-size-number'
);

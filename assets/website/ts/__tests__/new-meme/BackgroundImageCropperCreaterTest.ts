import { describe, expect, test } from '@jest/globals';
import BackgroundImageCropperCreater from '../../src/new-meme/BackgroundImageCropperCreater';
import MemeCanvasCreater from '../../src/new-meme/MemeCanvasCreater';
import Cropper from 'cropperjs';
import BackgroundImageFileInputRemover from '../../src/new-meme/BackgroundImageFileInputRemover';

jest.mock('cropperjs', (): any => {
    return jest.fn((): any => {
        return {
            getData: jest.fn().mockReturnValue({
                width: 100,
                height: 100,
                x: 50,
                y: 50,
            }),
            getImageData: jest.fn().mockReturnValue({
                naturalWidth: 500,
                naturalHeight: 500,
            }),
            ready: jest.fn(),
        };
    });
});
Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
    value: jest.fn((): any => ({
        drawImage: jest.fn(),
    })),
});
Object.defineProperty(MemeCanvasCreater.prototype, 'generate', {
    value: jest.fn((): any => null),
});

describe('generate background image cropper', (): void => {
    let memeTemplateImage: HTMLImageElement;
    let selectTextButton: HTMLButtonElement;

    beforeEach((): void => {
        document.body.innerHTML = `
            <button id="downloadButton"></button>
            <a id="selectTextButton" class="new-meme-button new-meme-settings-button"></a>
            <div id="memePreviewContainer"></div>
            <input class="memeTextInput hidden" />
            <input class="memeTextColorPicker hidden" />
            <input class="memeFontSizeInput hidden" />
            <input id="background-image-selector" type="file" accept="image/*" hidden>
            <label for="background-image-selector" class="new-meme-button new-meme-settings-button">Test</label>
            <div id="meme-preview-container">
                <img src="template.jpg" alt="test"/>
            </div>
            <div class="new-meme-canvas-container">
                <div class="new-meme-image-container">
                    <img src="template.jpg" alt="test"/>
                </div>
            </div>
        `;

        memeTemplateImage = document.querySelector(
            '.new-meme-image-container img',
        ) as HTMLImageElement;
        selectTextButton = document.getElementById('selectTextButton') as HTMLButtonElement;
    });

    test('generate background image cropper is successful', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
            new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage,
                backgroundImageFileInputRemover,
            );
        backgroundImageCropperGenerator.generate(backgroundImageFile);
        const expectedMemeTemplateImage = document.querySelector(
            '.new-meme-image-container img',
        ) as HTMLImageElement;
        expect(expectedMemeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector(
            '#memePreviewContainer img',
        ) as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('Continue');
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([]);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('<img>');
    });

    test('select text button is clicked', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
            new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage,
                backgroundImageFileInputRemover,
            );
        backgroundImageCropperGenerator.generate(backgroundImageFile);
        selectTextButton.click();

        const expectedMemeTemplateImage = document.querySelector(
            '.new-meme-image-container img',
        ) as HTMLImageElement;
        expect(expectedMemeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector(
            '#memePreviewContainer img',
        ) as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('Continue');
        const expectedMemeTextInput = document.querySelector('.memeTextInput') as HTMLElement;
        const expectedMemeTextColorPicker = document.querySelector(
            '.memeTextColorPicker',
        ) as HTMLElement;
        const expectedMemeFontSizeInput = document.querySelector(
            '.memeFontSizeInput',
        ) as HTMLElement;
        expect(Array.from(expectedMemeTextInput.classList)).toEqual(['memeTextInput']);
        expect(Array.from(expectedMemeTextColorPicker.classList)).toEqual(['memeTextColorPicker']);
        expect(Array.from(expectedMemeFontSizeInput.classList)).toEqual(['memeFontSizeInput']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([
            'new-meme-button',
            'new-meme-download-button',
        ]);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('<img>');
    });

    test('download button is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButtonWrong',
                    'selectTextButton',
                    'memePreviewContainer',
                    '.memeTextInput',
                    '.memeTextColorPicker',
                    '.memeFontSizeInput',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('select text button is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButton',
                    'selectTextButtonWrong',
                    'memePreviewContainer',
                    '.memeTextInput',
                    '.memeTextColorPicker',
                    '.memeFontSizeInput',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('meme preview container is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButton',
                    'selectTextButton',
                    'memePreviewContainerWrong',
                    '.memeTextInput',
                    '.memeTextColorPicker',
                    '.memeFontSizeInput',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('meme text input is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButton',
                    'selectTextButton',
                    'memePreviewContainer',
                    '.memeTextInputWrong',
                    '.memeTextColorPicker',
                    '.memeFontSizeInput',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('meme text color picker is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButton',
                    'selectTextButton',
                    'memePreviewContainer',
                    '.memeTextInput',
                    '.memeTextColorPickerWrong',
                    '.memeFontSizeInput',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('meme font size input is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
                new BackgroundImageFileInputRemover('background-image-selector');
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
                new BackgroundImageCropperCreater(
                    'downloadButton',
                    'selectTextButton',
                    'memePreviewContainer',
                    '.memeTextInput',
                    '.memeTextColorPicker',
                    '.memeFontSizeInputWrong',
                    memeTemplateImage,
                    backgroundImageFileInputRemover,
                );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });

    test('select text button is clicked with invalid data', (): void => {
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage,
            backgroundImageFileInputRemover,
        );
        selectTextButton.click();

        const expectedMemeTextInput = document.querySelector('.memeTextInput') as HTMLElement;
        const expectedMemeTextColorPicker = document.querySelector(
            '.memeTextColorPicker',
        ) as HTMLElement;
        const expectedMemeFontSizeInput = document.querySelector(
            '.memeFontSizeInput',
        ) as HTMLElement;
        expect(Array.from(expectedMemeTextInput.classList)).toEqual(['memeTextInput']);
        expect(Array.from(expectedMemeTextColorPicker.classList)).toEqual(['memeTextColorPicker']);
        expect(Array.from(expectedMemeFontSizeInput.classList)).toEqual(['memeFontSizeInput']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([
            'new-meme-button',
            'new-meme-download-button',
        ]);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('');
    });
    test('memeTemplateImage is equals to null', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater =
            new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage,
                backgroundImageFileInputRemover,
            );
        let memeTemplateImageContainer: HTMLElement = document.querySelector(
            '.new-meme-image-container',
        ) as HTMLElement;
        memeTemplateImageContainer.innerHTML = '';
        try {
            backgroundImageCropperGenerator.generate(backgroundImageFile);
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }
        selectTextButton.click();
        memeTemplateImage = document.querySelector(
            '.new-meme-image-container img',
        ) as HTMLImageElement;
        expect(memeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector(
            '#memePreviewContainer img',
        ) as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([]);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('<img>');
    });
    test('calls the ready function and updates the cropper-face element', () => {
        let backgroundImageFile: HTMLImageElement = new Image();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        const generator = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage,
            backgroundImageFileInputRemover,
        );

        generator.generate(backgroundImageFile);

        const readyCallback: any = (Cropper as any).mock.calls[0][1].ready;
        document.body.innerHTML += `<div class="cropper-face"></div>`;
        readyCallback();

        const expectedCropperFace = document.querySelector('.cropper-face') as HTMLElement;
        expect(expectedCropperFace).not.toBeNull();
        expect(expectedCropperFace.style.opacity).toBe('1');
        expect(expectedCropperFace.style.backgroundImage).toBe(`url(${memeTemplateImage.src})`);
        expect(expectedCropperFace.style.backgroundSize).toBe('cover');
        expect(expectedCropperFace.style.backgroundColor).toBe('transparent');
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('Continue');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('<img>');
    });
    test('calls the ready function and not updates the cropper-face element', () => {
        let backgroundImageFile: HTMLImageElement = new Image();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        const generator = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage,
            backgroundImageFileInputRemover,
        );

        generator.generate(backgroundImageFile);

        const readyCallback: any = (Cropper as any).mock.calls[0][1].ready;
        document.body.innerHTML += `<div class="cropper-face-wrong"></div>`;
        try {
            readyCallback();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }

        const expectedCropperFace = document.querySelector('.cropper-face') as HTMLElement;
        expect(expectedCropperFace).toBeNull();
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;
        expect(expectedSelectTextButton.textContent).toEqual('Continue');
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
        const expectedMemePreviewContainer = document.querySelector(
            '#memePreviewContainer',
        ) as HTMLImageElement;
        expect(expectedMemePreviewContainer.innerHTML).toBe('<img>');
    });
});

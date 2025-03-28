import {describe, expect, test} from '@jest/globals';
import BackgroundImageCropperCreater from '../../src/new-meme/BackgroundImageCropperCreater';
import MemeCanvasCreater from '../../src/new-meme/MemeCanvasCreater';
import Cropper from 'cropperjs';

jest.mock('cropperjs', (): any => {
    return jest.fn((): any => {
        return {
            getData: jest.fn().mockReturnValue({
                width: 100,
                height: 100,
                x: 50,
                y: 50
            }),
            getImageData: jest.fn().mockReturnValue({
                naturalWidth: 500,
                naturalHeight: 500
            }),
            ready: jest.fn()
        };
    });
});
Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
    value: jest.fn((): any => ({
        drawImage: jest.fn()
    })),
});
Object.defineProperty(MemeCanvasCreater.prototype, 'generate', {
    value: jest.fn((): any => null),
});

describe('generate background image cropper', (): void => {
    let memeTemplateImage: HTMLImageElement;
    let selectTextButton: HTMLButtonElement

    beforeEach((): void => {
        document.body.innerHTML = `
            <button id="downloadButton"></button>
            <a id="selectTextButton" class="new-meme-button new-meme-settings-button"></a>
            <div id="memePreviewContainer"></div>
            <input class="memeTextInput hidden" />
            <input class="memeTextColorPicker hidden" />
            <input class="memeFontSizeInput hidden" />
            <div id="meme-preview-container">
                <img src="template.jpg" alt="test"/>
            </div>
            <div class="new-meme-canvas-container">
                <div class="new-meme-image-container">
                    <img src="template.jpg" alt="test"/>
                </div>
            </div>
        `;

        memeTemplateImage = document.querySelector('.new-meme-image-container img') as HTMLImageElement;
        selectTextButton = document.getElementById('selectTextButton') as HTMLButtonElement;
    });

    test('generate background image cropper is successful', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
        );
        backgroundImageCropperGenerator.generate(backgroundImageFile);
        const expectedMemeTemplateImage = document.querySelector('.new-meme-image-container img') as HTMLImageElement;
        expect(expectedMemeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector('#memePreviewContainer img') as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button', 'new-meme-settings-button']);
        expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button', 'new-meme-settings-button']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([]);
    });

    test('select text button is clicked', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
        );
        backgroundImageCropperGenerator.generate(backgroundImageFile);
        selectTextButton.click();

        const expectedMemeTemplateImage = document.querySelector('.new-meme-image-container img') as HTMLImageElement;
        expect(expectedMemeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector('#memePreviewContainer img') as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button-disabled']);
        expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button-disabled']);
        const expectedMemeTextInput = document.querySelector('.memeTextInput') as HTMLElement;
        const expectedMemeTextColorPicker = document.querySelector('.memeTextColorPicker') as HTMLElement;
        const expectedMemeFontSizeInput = document.querySelector('.memeFontSizeInput') as HTMLElement;
        expect(Array.from(expectedMemeTextInput.classList)).toEqual(['memeTextInput']);
        expect(Array.from(expectedMemeTextColorPicker.classList)).toEqual(['memeTextColorPicker']);
        expect(Array.from(expectedMemeFontSizeInput.classList)).toEqual(['memeFontSizeInput']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual(['new-meme-button', 'new-meme-download-button']);
    });

    test('download button is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButtonWrong',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('select text button is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButtonWrong',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('meme preview container is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainerWrong',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('meme text input is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInputWrong',
                '.memeTextColorPicker',
                '.memeFontSizeInput',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('meme text color picker is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPickerWrong',
                '.memeFontSizeInput',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('meme font size input is not found', (): void => {
        try {
            let backgroundImageFile: HTMLImageElement = new Image();
            const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
                'downloadButton',
                'selectTextButton',
                'memePreviewContainer',
                '.memeTextInput',
                '.memeTextColorPicker',
                '.memeFontSizeInputWrong',
                memeTemplateImage
            );
            backgroundImageCropperGenerator.generate(backgroundImageFile);
            selectTextButton.click();
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.')
        }
    });

    test('select text button is clicked with invalid data', (): void => {
        new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
        );
        selectTextButton.click();

        const expectedMemeTextInput = document.querySelector('.memeTextInput') as HTMLElement;
        const expectedMemeTextColorPicker = document.querySelector('.memeTextColorPicker') as HTMLElement;
        const expectedMemeFontSizeInput = document.querySelector('.memeFontSizeInput') as HTMLElement;
        expect(Array.from(expectedMemeTextInput.classList)).toEqual(['memeTextInput', 'hidden']);
        expect(Array.from(expectedMemeTextColorPicker.classList)).toEqual(['memeTextColorPicker', 'hidden']);
        expect(Array.from(expectedMemeFontSizeInput.classList)).toEqual(['memeFontSizeInput', 'hidden']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([]);
    });
    test('memeTemplateImage is equals to null', (): void => {
        let backgroundImageFile: HTMLImageElement = new Image();
        const backgroundImageCropperGenerator: BackgroundImageCropperCreater = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
        );
        let memeTemplateImageContainer: HTMLElement = document.querySelector('.new-meme-image-container') as HTMLElement;
        memeTemplateImageContainer.innerHTML = '';
        try {
            backgroundImageCropperGenerator.generate(backgroundImageFile);
        } catch (error: any) {
            expect(error.message).toBe('Background image cropper could not be created.');
        }
        memeTemplateImage = document.querySelector('.new-meme-image-container img') as HTMLImageElement;
        expect(memeTemplateImage).not.toBeInstanceOf(HTMLImageElement);
        const expectedBackgroundImage = document.querySelector('#memePreviewContainer img') as HTMLImageElement;
        expect(expectedBackgroundImage).toBeInstanceOf(HTMLImageElement);
        const expectedSelectTextButton = document.getElementById('selectTextButton') as HTMLElement;expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button', 'new-meme-settings-button']);
        expect(Array.from(expectedSelectTextButton.classList)).toEqual(['new-meme-button', 'new-meme-settings-button']);
        const expectedDownloadButton = document.getElementById('downloadButton') as HTMLElement;
        expect(Array.from(expectedDownloadButton.classList)).toEqual([]);
    });
    test('calls the ready function and updates the cropper-face element', () => {
        let backgroundImageFile: HTMLImageElement = new Image();
        const generator = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
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
    });
    test('calls the ready function and not updates the cropper-face element', () => {
        let backgroundImageFile: HTMLImageElement = new Image();
        const generator = new BackgroundImageCropperCreater(
            'downloadButton',
            'selectTextButton',
            'memePreviewContainer',
            '.memeTextInput',
            '.memeTextColorPicker',
            '.memeFontSizeInput',
            memeTemplateImage
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
    });
});

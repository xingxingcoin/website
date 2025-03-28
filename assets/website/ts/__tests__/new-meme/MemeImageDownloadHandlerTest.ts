import {describe, expect, test} from '@jest/globals';
import MemeImageDownloadHandler from '../../src/new-meme/MemeImageDownloadHandler';


describe('handle meme image for download', (): void => {
    let downloadButton: HTMLInputElement;
    let memeImageCanvas: HTMLCanvasElement;
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <label id="new-meme-download-button">Test</label>
            <input type="color" class="new-meme-input-color-picker">
            <input type="number" class="new-meme-input-font-size-number">
            <div id="meme-preview-container"><div><canvas height="0" width="0"></canvas><p>Test</p></div></div>
        </div>`;

        downloadButton = document.getElementById('new-meme-download-button') as HTMLInputElement;
        memeImageCanvas = document.querySelector('#meme-preview-container div canvas') as HTMLCanvasElement;
    });

    test('handle meme image for download is successful', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn(),
                fillText: jest.fn(),
                strokeText: jest.fn()
            })),
        });

        const memeCanvasContainer: HTMLDivElement = document.querySelector('#meme-preview-container div') as HTMLDivElement;
        const memeCanvasContainerRect = {
            width: 400,
            height: 400,
            x: 100,
            y: 100
        } as DOMRect;
        jest.spyOn(memeCanvasContainer, 'getBoundingClientRect').mockReturnValue(memeCanvasContainerRect);
        const memeText: HTMLParagraphElement = document.querySelector('#meme-preview-container div p') as HTMLParagraphElement;
        const memeTextRect = {
            width: 400,
            height: 400,
            x: 100,
            y: 100
        } as DOMRect;
        jest.spyOn(memeText, 'getBoundingClientRect').mockReturnValue(memeTextRect);

        const memeFileDownloaderMock: any = {
            download: jest.fn()
        };
        new MemeImageDownloadHandler(
            memeFileDownloaderMock,
            'new-meme-download-button',
            '.new-meme-input-color-picker',
            '.new-meme-input-font-size-number'
        );

        downloadButton.click();

        memeImageCanvas.width = 400;
        memeImageCanvas.height = 400;
        expect(memeFileDownloaderMock.download).toHaveBeenCalledWith(memeImageCanvas);
    });

    test('context equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => null),
        });

        const memeCanvasContainer: HTMLDivElement = document.querySelector('#meme-preview-container div') as HTMLDivElement;
        const memeCanvasContainerRect = {
            width: 400,
            height: 400,
            x: 100,
            y: 100
        } as DOMRect;
        jest.spyOn(memeCanvasContainer, 'getBoundingClientRect').mockReturnValue(memeCanvasContainerRect);
        const memeText: HTMLParagraphElement = document.querySelector('#meme-preview-container div p') as HTMLParagraphElement;
        const memeTextRect = {
            width: 400,
            height: 400,
            x: 100,
            y: 100
        } as DOMRect;
        jest.spyOn(memeText, 'getBoundingClientRect').mockReturnValue(memeTextRect);

        const memeFileDownloaderMock: any = {
            download: jest.fn()
        };
        new MemeImageDownloadHandler(
            memeFileDownloaderMock,
            'new-meme-download-button',
            '.new-meme-input-color-picker',
            '.new-meme-input-font-size-number'
        );

        downloadButton.click();

        memeImageCanvas.width = 400;
        memeImageCanvas.height = 400;
        expect(memeFileDownloaderMock.download).not.toHaveBeenCalledWith(memeImageCanvas);
    });

    test('download button equals null', (): void => {
        const memeFileDownloaderMock: any = {
            download: jest.fn()
        };
        try {
            new MemeImageDownloadHandler(
                memeFileDownloaderMock,
                'new-meme-download-button-wrong',
                '.new-meme-input-color-picker',
                '.new-meme-input-font-size-number'
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme image image could not be downloaded.');
        }
    });
    test('input color picker equals null', (): void => {
        const memeFileDownloaderMock: any = {
            download: jest.fn()
        };
        try {
            new MemeImageDownloadHandler(
                memeFileDownloaderMock,
                'new-meme-download-button',
                '.new-meme-input-color-picker-wrong',
                '.new-meme-input-font-size-number'
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme image image could not be downloaded.');
        }
    });
    test('input font size number equals null', (): void => {
        const memeFileDownloaderMock: any = {
            download: jest.fn()
        };
        try {
            new MemeImageDownloadHandler(
                memeFileDownloaderMock,
                'new-meme-download-button',
                '.new-meme-input-color-picker',
                '.new-meme-input-font-size-number-wrong'
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme image image could not be downloaded.');
        }
    });
});

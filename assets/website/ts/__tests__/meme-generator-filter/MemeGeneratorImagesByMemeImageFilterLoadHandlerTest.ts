import { describe, expect, test } from '@jest/globals';
import MemeGeneratorImagesByMemeImageFilterLoadHandler from '../../src/meme-generator-filter/MemeGeneratorImagesByMemeImageFilterLoadHandler';

describe('Meme generator images by meme image filter loaded', (): void => {
    let memeImageFilterButton: HTMLAnchorElement;
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <a id="xing-media-meme-image-filter-button" class="xing-media-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;

        memeImageFilterButton = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
    });

    test('Meme generator images by meme image filter loaded successful', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };
        new MemeGeneratorImagesByMemeImageFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-image-filter-button',
            '.xing-media-container',
        );

        memeImageFilterButton.click();

        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="lds-dual-ring"></div>',
        );
    });

    test('Meme generator images by no filter loaded successful', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };
        document.body.innerHTML = `<div>
            <a id="xing-media-meme-image-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        memeImageFilterButton = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        new MemeGeneratorImagesByMemeImageFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-image-filter-button',
            '.xing-media-container',
        );

        memeImageFilterButton.click();

        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="lds-dual-ring"></div>',
        );
    });

    test('meme image filter button contains disabled class', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };
        document.body.innerHTML = `<div>
            <a id="xing-media-meme-image-filter-button" class="xing-media-filter-button-disabled"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        memeImageFilterButton = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        new MemeGeneratorImagesByMemeImageFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-image-filter-button',
            '.xing-media-container',
        );

        memeImageFilterButton.click();

        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">',
        );
    });
    test('meme image filter button is not found', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };

        try {
            new MemeGeneratorImagesByMemeImageFilterLoadHandler(
                memeGeneratorImagesByMemeImageFilterLoaderMock,
                memeGeneratorImagesByNoFilterLoaderMock,
                'xing-media-meme-image-filter-button-wrong',
                '.xing-media-container',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme generator images by meme image filter not loaded.');
        }

        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">',
        );
    });
    test('media container is not found', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };

        try {
            new MemeGeneratorImagesByMemeImageFilterLoadHandler(
                memeGeneratorImagesByMemeImageFilterLoaderMock,
                memeGeneratorImagesByNoFilterLoaderMock,
                'xing-media-meme-image-filter-button',
                '.xing-media-container-wrong',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme generator images by meme image filter not loaded.');
        }

        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">',
        );
    });
});

import { describe, expect, test } from '@jest/globals';
import MemeGeneratorImagesByMemeTemplateFilterLoadHandler from '../../src/meme-generator-filter/MemeGeneratorImagesByMemeTemplateFilterLoadHandler';

describe('Meme generator images by meme template filter loaded', (): void => {
    let memeTemplateFilterButton: HTMLAnchorElement;
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <a id="xing-media-meme-template-filter-button" class="xing-media-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
    });

    test('Gallery images by gif filter loaded successful', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };
        new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-template-filter-button',
            '.xing-media-container',
        );

        memeTemplateFilterButton.click();

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(memeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button-selected',
        ]);
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
            <a id="xing-media-meme-template-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-template-filter-button',
            '.xing-media-container',
        );

        memeTemplateFilterButton.click();

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(memeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button',
        ]);
        expect(memeGeneratorImagesByMemeImageFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(memeGeneratorImagesByNoFilterLoaderMock.load).toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector(
            '.xing-media-container',
        ) as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="lds-dual-ring"></div>',
        );
    });

    test('meme template filter button contains disabled class', (): void => {
        let memeGeneratorImagesByMemeImageFilterLoaderMock: any = {
            load: jest.fn(),
        };
        let memeGeneratorImagesByNoFilterLoaderMock: any = {
            load: jest.fn(),
        };
        document.body.innerHTML = `<div>
            <a id="xing-media-meme-template-filter-button" class="xing-media-filter-button-disabled"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
            memeGeneratorImagesByMemeImageFilterLoaderMock,
            memeGeneratorImagesByNoFilterLoaderMock,
            'xing-media-meme-template-filter-button',
            '.xing-media-container',
        );

        memeTemplateFilterButton.click();

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(memeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button-disabled',
        ]);
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
            new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
                memeGeneratorImagesByMemeImageFilterLoaderMock,
                memeGeneratorImagesByNoFilterLoaderMock,
                'xing-media-meme-template-filter-button-wrong',
                '.xing-media-container',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme generator images by meme template filter not loaded.');
        }

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(memeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button',
        ]);
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
            new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
                memeGeneratorImagesByMemeImageFilterLoaderMock,
                memeGeneratorImagesByNoFilterLoaderMock,
                'xing-media-meme-template-filter-button',
                '.xing-media-container-wrong',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme generator images by meme template filter not loaded.');
        }

        memeTemplateFilterButton = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(memeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button',
        ]);
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

import {describe, test} from '@jest/globals';
import MemeFileDownloader from '../../src/new-meme/MemeFileDownloader';

describe('download meme file', (): void => {
    test('download meme file successfully', (): void => {
        const mockBlob = new Blob();
        let memeCanvas: any = {
            toBlob: jest.fn((callback: any): any => callback(mockBlob))
        }
        global.URL.createObjectURL = jest.fn((): string => 'mock-url');
        global.URL.revokeObjectURL = jest.fn();

        const mockAnchor: any = {
            click: jest.fn(),
            setAttribute: jest.fn(),
            href: '',
            download: '',
        };
        jest.spyOn(document, 'createElement').mockReturnValue(mockAnchor);

        const memeFileDownloader = new MemeFileDownloader();
        memeFileDownloader.download(memeCanvas);

        expect(memeCanvas.toBlob).toHaveBeenCalled();
        expect(URL.createObjectURL).toHaveBeenCalledWith(mockBlob);
        expect(mockAnchor.href).toBe('mock-url');
        expect(mockAnchor.download).toBe('xing-meme.png');
        expect(mockAnchor.click).toHaveBeenCalled();
        expect(URL.revokeObjectURL).toHaveBeenCalledWith('mock-url');
    });
});

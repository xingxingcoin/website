import { describe, expect, test } from '@jest/globals';
import NavigationAudioPlayer from '../../src/navigation-audio-player/NavigationAudioPlayer';

describe('add navigation audio player', (): void => {
    let navigationAudioPlayerButton: HTMLButtonElement;
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <button class="navigation-audio-player-button">Test</button>
            <audio id="navigation-audio-player">
                <source src="test" type="audio/mpeg">
            </audio>
        </div>`;

        navigationAudioPlayerButton = document.querySelector(
            '.navigation-audio-player-button',
        ) as HTMLButtonElement;
    });
    test('play navigation audio player music is successful', (): void => {
        Object.defineProperty(HTMLAudioElement.prototype, 'play', {
            value: jest.fn(),
        });

        new NavigationAudioPlayer('.navigation-audio-player-button');
        navigationAudioPlayerButton.click();
        expect(navigationAudioPlayerButton.innerHTML.replace(/\s+/g, '')).toBe(
            `<svgid="pauseIcon"width="24"height="24"viewBox="002424"fill="black"xmlns="http://www.w3.org/2000/svg"><pathd="M65h4v14H6zM145h4v14h-4z"></path></svg>`,
        );
    });
    test('pause navigation audio player music is successful', (): void => {
        let audioPlayer: HTMLAudioElement = document.getElementById(
            'navigation-audio-player',
        ) as HTMLAudioElement;
        Object.defineProperty(audioPlayer, 'paused', {
            get: jest.fn((): boolean => false),
            configurable: true,
        });
        Object.defineProperty(HTMLAudioElement.prototype, 'pause', {
            value: jest.fn(),
        });

        new NavigationAudioPlayer('.navigation-audio-player-button');
        navigationAudioPlayerButton.click();

        expect(navigationAudioPlayerButton.innerHTML.replace(/\s+/g, '')).toBe(
            `<svgid="playIcon"width="24"height="24"viewBox="002424"fill="black"xmlns="http://www.w3.org/2000/svg"><pathd="M85v14l11-7z"></path></svg>`,
        );
    });
    test('end navigation audio player music is successful', (): void => {
        let audioPlayer: HTMLAudioElement = document.getElementById(
            'navigation-audio-player',
        ) as HTMLAudioElement;
        new NavigationAudioPlayer('.navigation-audio-player-button');
        navigationAudioPlayerButton.click();
        audioPlayer.dispatchEvent(new Event('ended'));

        expect(navigationAudioPlayerButton.innerHTML.replace(/\s+/g, '')).toBe(
            `<svgid="playIcon"width="24"height="24"viewBox="002424"fill="black"xmlns="http://www.w3.org/2000/svg"><pathd="M85v14l11-7z"></path></svg>`,
        );
    });
    test('audio player is equals to null', (): void => {
        let audioPlayer: HTMLAudioElement = document.getElementById(
            'navigation-audio-player',
        ) as HTMLAudioElement;
        audioPlayer.remove();

        new NavigationAudioPlayer('.navigation-audio-player-button');
        navigationAudioPlayerButton.click();

        expect(navigationAudioPlayerButton.innerHTML.replace(/\s+/g, '')).toBe(`Test`);
    });
    test('audio player is equals to null', (): void => {
        try {
            new NavigationAudioPlayer('.navigation-audio-player-button-wrong');
        } catch (error: any) {
            expect(error.message).toBe('Navigation audio player not found.');
        }

        expect(navigationAudioPlayerButton.innerHTML.replace(/\s+/g, '')).toBe(`Test`);
    });
});

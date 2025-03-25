export default class ContainerAnimationInitializer {
    public init(): void
    {
        const hiddenContainerCollection: NodeList = document.querySelectorAll('.container-left-hidden, .container-bottom-hidden');
        Array.from(hiddenContainerCollection).forEach((hiddenContainer: HTMLDivElement): void => {
            window.addEventListener('scroll', (): void => {
                const rect: DOMRect = hiddenContainer.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9) {
                    hiddenContainer.classList.add('container-show');
                } else {
                    hiddenContainer.classList.remove('container-show');
                }
            });
        });
    }
}

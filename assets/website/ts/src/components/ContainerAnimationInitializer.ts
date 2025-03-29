export default class ContainerAnimationInitializer {
    public init(): void
    {
        const hiddenContainerCollection: NodeList = document.querySelectorAll('.container-left-hidden, .container-bottom-hidden');
        Array.from(hiddenContainerCollection).forEach((hiddenContainer: any): void => {
            this.changeClass(hiddenContainer);
            window.addEventListener('scroll', (): void => {
                this.changeClass(hiddenContainer);
            });
        });
    }

    private changeClass(hiddenContainer: any): void
    {
        const rect: DOMRect = hiddenContainer.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.9) {
            hiddenContainer.classList.add('container-show');
        } else {
            hiddenContainer.classList.remove('container-show');
        }
    }
}

import React from 'react';

type Props = {
    children: React.ReactNode;
};

type State = {
    hasError: boolean;
};

class ErrorBoundary extends React.Component<Props, State> {

    state: State = {
        hasError: false,
    };

    static getDerivedStateFromError() {
        return {
            hasError: true,
        };
    }

    componentDidCatch(error: Error, info: React.ErrorInfo) {
        console.error(error, info.componentStack);
    }

    handleReset = () => {
        this.setState({
            hasError: false,
        });
    };

    render() {

        if (this.state.hasError) {
            return (
                <div className="flex min-h-screen items-center justify-center bg-gray-100 px-4">
                    <div className="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">

                        <div className="mb-6 flex justify-center">
                            <div className="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                <span className="text-3xl">⚠️</span>
                            </div>
                        </div>

                        <h1 className="mb-2 text-center text-2xl font-bold text-gray-900">
                            Something went wrong
                        </h1>

                        <p className="mb-6 text-center text-sm text-gray-500">
                            An unexpected error occurred while loading the application.
                        </p>

                        <button
                            onClick={this.handleReset}
                            className="w-full rounded-xl bg-black px-4 py-3 text-sm font-medium text-white transition hover:opacity-90"
                        >
                            Try Again
                        </button>

                    </div>
                </div>
            );
        }

        return this.props.children;
    }
}

export default ErrorBoundary;

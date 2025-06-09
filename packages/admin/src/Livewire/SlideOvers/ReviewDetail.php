<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Review;
use Tinoecom\Livewire\Components\SlideOverComponent;

class ReviewDetail extends SlideOverComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Review $review;

    public function mount(): void
    {
        $this->review->load('author', 'reviewrateable');
    }

    public function approvedAction(): Action
    {
        return Action::make('approved')
            ->label(__('tinoecom::forms.actions.update'))
            ->size(ActionSize::Small)
            ->action(function (): void {
                $this->review->updatedApproved(! $this->review->approved);

                Notification::make()
                    ->title(__('tinoecom::pages/products.reviews.approved_message'))
                    ->success()
                    ->send();

                $this->redirectRoute(name: 'tinoecom.reviews.index', navigate: true);
            });
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.review-detail');
    }
}
